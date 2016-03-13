<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Major;
use App\Course;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_admin');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function add_course_page()
    {
        $courses = Course::all();
        $majors = Major::all();

        return view('admin.add_course',compact(['courses','majors']));
    }


    public function add_course(Request $request)
    {
//        dd($request);
        $this->validate($request, [
            'course_code' => 'alpha_num|required',
            'course_name' => 'required',
            'semester' => 'numeric|between:1,10|required',
            'majors.*' => 'numeric|exists:majors,id'
        ]);

        $course = new Course();
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->semester = $request->semester;
        $course->save();
        $course->majors()->attach($request->majors);
        return redirect('admin/add_course');
    }

    public function delete_course($id)
    {
        $course = Course::find($id);
        $course->delete();
        return redirect('/admin/add_course');
    }

    public function update_course_page($id)
    {

        $course = Course::find($id);
        $majors = Major::all();

        $course_majors = array();
        foreach($course->majors()->get() as $major)
            $course_majors[] = $major->id;

        return view('admin.update_course',compact(['course','majors','course_majors']));

    }

    public function update_course($id, Request $request)
    {
        $this->validate($request, [
            'course_code' => 'alpha_num|required',
            'course_name' => 'required',
            'semester' => 'numeric|between:1,10|required',
            'majors.*' => 'numeric|exists:majors,id'
        ]);

        $course = Course::find($id);
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->semester = $request->semester;
        $course->save();
        $course->majors()->detach();
        $course->majors()->attach($request->majors);
        return redirect('admin/add_course');
    }


    public function add_major_page()
    {
        $majors = Major::all();
        return view('admin.add_major',compact(['courses','majors']));
    }

    public function add_major(Request $request)
    {
        $this->validate($request, [
            'faculty' => 'required',
            'major' => 'required',
        ]);
        $major = new Major();
        $major->faculty = $request->faculty;
        $major->major = $request->major;
        $major->save();
        return redirect('/admin/add_major');
    }

    public function delete_major($id)
    {
        $major = Major::find($id);
        $major->delete();
        return redirect('/admin/add_major');
    }

    public function update_major_page($id)
    {
        $major = Major::find($id);
        return view('admin.update_major',compact(['major']));
    }

    public function update_major($id, Request $request)
    {
        $this->validate($request, [
            'faculty' => 'required',
            'major' => 'required',
        ]);

        $major = Major::find($id);
        $major->faculty = $request->faculty;
        $major->major = $request->major;
        $major->save();
        return redirect('admin/add_major');
    }







}
