@extends('layouts.app')
@section('content')
    <style>
        table td, table th
        {
            border: 1px solid black;
            padding: 7px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/zf/dt-1.10.11/datatables.min.css"/>
    <div class="container">
        <table class="table table-striped table-bordered" style="width:100%;" id="courses_table">
            <thead>
            <tr>
                <th>Course code</th>
                <th>Course name</th>
                <th>Majors</th>`
                <th>Semester</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            </thead>
            <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{$course->course_code}}</td>
                    <td>{{$course->course_name}}</td>
                    <td>
                        <ul>
                            @foreach($course->majors()->get() as $major)
                                <li>{{$major->major}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{$course->semester}}</td>
                    <td><a onclick="return confirm('Are you sure?');" href="{{url('admin/delete_course/'.$course->id)}}">Delete</a></td>
                    <td><a href="{{url('admin/update_course/'.$course->id)}}">Update</a></td>
                </tr>


            @endforeach
            </tbody>
        </table>
        <form method="POST" action="{{url('admin/add_course')}}" style="padding: 50px; width: 50%;">
            {{csrf_field()}}
            <div class="form-group">
                <label for="course_code">Course Code</label>
                <input type="text" class="form-control" id="course_code" name="course_code" placeholder="Course Code">
            </div>
            <div class="form-group">
                <label for="course_name">Course Name</label>
                <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Course Name">
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="number" min="1" max="10" class="form-control" id="semester" name="semester" placeholder="Semester">
            </div>
            <div class="form-group">
                <label for="majors">Majors</label>
                <br>
                @foreach($majors as $major)
                    <input type="checkbox" name="majors[]" value="{{$major->id}}"> {{$major->major}} <br>
                @endforeach
            </div>
            <button type="submit" class="btn btn-default">Add Course</button>

            <div class="error" style="color:red">
                @include('errors')
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/t/zf/dt-1.10.11/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#courses_table').DataTable();
        } );
    </script>

    <style>
        #courses_table_wrapper
        {
            width: 70%;
        }
        .odd {
            background-color: #FFECDC !important;
        }

        #courses_table thead tr {
            background-color: #FFCEA5;
        }
    </style>
@endsection