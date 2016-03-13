@extends('layouts.app')
@section('content')
    <style>
        table td, table th
        {
            border: 1px solid black;
            padding: 7px;
            max-width: 300px;
        }
    </style>
    <div class="container">
        <table style="">
            <tr>
                <th>Faculty</th>
                <th>Major Name</th>
                <th>Courses</th>`
                <th>Delete</th>
                <th>Update</th>

            </tr>
            @foreach($majors as $major)
                <tr>
                    <td>{{$major->faculty}}</td>
                    <td>{{$major->major}}</td>
                    <td>
                        <ul>
                            @foreach($major->courses()->get() as $course)
                                <li>{{$course->course_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td><a onclick="return confirm('Are you sure?');" href="{{url('admin/delete_major/'.$major->id)}}">Delete</a></td>
                    <td><a href="{{url('admin/update_major/'.$major->id)}}">Update</a></td>
                </tr>

            @endforeach
        </table>
        <form method="POST" action="{{url('admin/add_major')}}" style="padding: 50px; width: 50%;">
            {{csrf_field()}}
            <div class="form-group">
                <label for="faculty">Faculty</label>
                <input type="text" class="form-control" id="faculty" name="faculty" placeholder="Faculty">
            </div>
            <div class="form-group">
                <label for="major">Major Name</label>
                <input type="text" class="form-control" id="major" name="major" placeholder="Major">
            </div>


            <button type="submit" class="btn btn-default">Add Major</button>
            <div class="error" style="color:red">
                @include('errors')
            </div>
        </form>
    </div>

@endsection