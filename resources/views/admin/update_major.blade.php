@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="POST" action="{{url('admin/update_major/'.$major->id)}}" style="padding: 50px; width: 50%;">
            {{csrf_field()}}
            <div class="form-group">
                <label for="faculty">Faculty</label>
                <input type="text" class="form-control" id="faculty" name="faculty" value="{{$major->faculty}}">
            </div>
            <div class="form-group">
                <label for="course_name">Major</label>
                <input type="text" class="form-control" id="major" name="major" value="{{$major->major}}">
            </div>

            <button type="submit" class="btn btn-default">Update Major</button>

            <div class="error" style="color:red">
                @include('errors')
            </div>
        </form>
    </div>

@endsection