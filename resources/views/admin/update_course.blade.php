@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="POST" action="{{url('admin/update_course/'.$course->id)}}" style="padding: 50px; width: 50%;">
            {{csrf_field()}}
            <div class="form-group">
                <label for="course_code">Course Code</label>
                <input type="text" class="form-control" id="course_code" name="course_code" value="{{$course->course_code}}">
            </div>
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="{{$course->course_name}}">
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="number" min="1" max="10" class="form-control" id="semester" name="semester" value="{{$course->semester}}">
            </div>
            <div class="form-group">
                <label for="majors">Majors</label>
                <br>
                @foreach($majors as $major)
                    <input {{in_array($major->id, $course_majors)?'checked':''}} type="checkbox" name="majors[]" value="{{$major->id}}"> {{$major->major}} <br>
                @endforeach
            </div>
            <button type="submit" class="btn btn-default">Update Course</button>

            <div class="error" style="color:red">
                @include('errors')
            </div>
        </form>
    </div>

@endsection