<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Http\Requests\SchoolYearRequest;
use Illuminate\Support\Carbon;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = SchoolYear::latest()->get();
        return view('admin.school_year', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SchoolYearRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolYearRequest $request)
    {
        $parseFrom = Carbon::parse($request->date_from);
        $parseTo = Carbon::parse($request->date_to);

        if ($parseFrom->gte($parseTo) || SchoolYear::hasConflict($request->date_from, $request->date_to)) {
            return redirect()->back()
                ->with('error', ["Date Conflict", "Sorry, there is a conflict with the selected dates. Please choose different date ranges"]);
        }

        SchoolYear::create([
            'name' => $request->name,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        return redirect()->back()
                ->with('success', ["New School Year", ucwords($request->name) . " has been successfully added."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolYear  $school_year
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $school_year)
    {
        return $school_year;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SchoolYearRequest $request
     * @param  \App\Models\SchoolYear  $school_year
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolYearRequest $request, SchoolYear $school_year)
    {
        if (SchoolYear::where('id', '!=', $school_year->id)->hasConflict($request->date_from, $request->date_to)) {
            return redirect()->back()
                ->with('error', ["Date Conflict", "Sorry, there is a conflict with the selected dates. Please choose different date ranges"]);
        }

        $school_year->update([
            'name' => $request->name,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        return $school_year->wasChanged()
            ? redirect()->back()
                ->with('update', ["School Year Updated", $school_year->name . " has been successfully changed."])
            : redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolYear  $school_year
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $school_year)
    {
        $school_year->update(['is_deleted' => 1]);

        return redirect()->back()->with('destroy', ["School Year Deleted", $school_year->name . " has been successfully deleted"]);
    }
}
