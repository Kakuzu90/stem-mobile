<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Http\Requests\ModuleRequest;
use App\Models\BaseModel;
use App\Models\Classroom;
use App\Models\ClassroomModule;
use App\Models\TeacherSubject;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::latest()->get();
        $data['classrooms'] = Classroom::latest()->get();
        return view('admin.module', compact('modules', 'data'));
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
        return [
            'title' => $module->title,
            'classroom' => $module->classrooms?->first()?->classroom_id,
            'publish' => $module->is_published,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ModuleRequest  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, Module $module)
    {
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
        $module->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["Module Deleted", $module->title . " has been successfully deleted."]);
    }

    public function subjects(Module $module, Classroom $classroom) {
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
