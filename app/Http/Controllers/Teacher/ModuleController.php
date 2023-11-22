<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassroomModule;
use App\Models\Module;
use App\Models\BaseModel;
use App\Models\TeacherSubject;
use App\Http\Requests\ModuleRequest;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Auth::guard('teacher')->user()->classrooms;
        $modules = ClassroomModule::whereIn('classroom_id', $classrooms->pluck('classroom_id'))
                        ->join('modules', 'classroom_modules.module_id', '=', 'modules.id')
                        ->where('modules.is_deleted', 0)
                        ->select('module_id')->distinct()->get();
        return view('teacher.module', compact('modules', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ModuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
        if ($request->hasFile('module')) {
            $filename = time() .".". $request->file('module')->getClientOriginalExtension();
            $request->file('module')->storeAs('public/modules', $filename);

            $module = Module::create([
                'title' => $request->title,
                'path' => $filename,
                'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED,
            ]);

            foreach($request->subjects as $subject) {
                ClassroomModule::create([
                    'module_id' => $module->id,
                    'classroom_id' => $request->classroom,
                    'subject_id' => $subject,
                ]);
            }

            return redirect()->back()->with('success', ["New Module Added", ucwords($request->title) . " has been successfully added."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        abort_if(
            $module->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        return [
            'title' => $module->title,
            'classroom' => $module->classrooms?->first()?->classroom_id,
            'publish' => $module->is_published,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ModuleRequest $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, Module $module)
    {
        abort_if(
            $module->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $update = [
            'title' => $request->title,
            'is_published' => $request->publish ?? BaseModel::NO_PUBLISHED
        ];

        if ($request->hasFile('module')) {
            unlink(storage_path('app/public/modules' . $module->path));
            $filename = time() .".". $request->file('module')->getClientOriginalExtension();
            $request->file('module')->storeAs('public/modules', $filename);
            $update['path'] = $filename;
        }

        $module->update($update);
        ClassroomModule::where('module_id', $module->id)->where('classroom_id', $request->classroom)->delete();
        foreach($request->subjects as $subject) {
            ClassroomModule::create([
                'module_id' => $module->id,
                'classroom_id' => $request->classroom,
                'subject_id' => $subject,
            ]);
        }

        return $module->wasChanged()
            ? redirect()->back()->with('update', ["Module Updated", $module->title . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        abort_if(
            $module->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $module->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Module Deleted", $module->title . " has been successfully deleted."]);
    }

    public function subjects(Module $module, Classroom $classroom) {
        abort_if(
            $module->classrooms?->first()->classroom->teacher_id !== Auth::guard('teacher')->id(),
            404
        );
        $query = ClassroomModule::where('module_id', $module->id)
                    ->where('classroom_id', $classroom->id);
        $classroomSubjects = TeacherSubject::where('classroom_id', $classroom->id);
        if ($query->exists()) {
            $subjects = $query->get('subject_id')->pluck('subject_id');
        }else {
            $subjects = $classroomSubjects->get('subject_id')->pluck('subject_id');
        }

        return [
            'subjects' => $subjects,
            'options' => $classroomSubjects->get('subject_id')->map(function($item) {
                return ['id' => $item->subject_id, 'text' => $item->subject->name];
            }),
        ];
    }
}
