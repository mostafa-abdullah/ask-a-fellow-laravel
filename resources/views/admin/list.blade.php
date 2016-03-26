@extends('layouts.app')
@section('content')
    <div class="" style="padding: 50px;">
        <table class="table table-hover center-block" style="text-align: center; width: 50%;">
            <tr>
                <td>
                    <a href="{{url('admin/add_course')}}">Add Course</a>
                </td>
            </tr>

            <tr>
                <td>
                    <a href="{{url('admin/add_major')}}">Add Major</a>
                </td>
            </tr>

            <tr>
                <td>
                    <a href="{{url('admin/feedbacks')}}">View Feedbacks</a>
                </td>
            </tr>

            <tr>
                <td>
                    <a href="{{url('admin/reports')}}">View Reports</a>
                </td>
            </tr>

            <tr>
                <td>
                    <a href="{{url('admin/ban')}}">Ban a User</a>
                </td>
            </tr>

        </table>
    </div>
@endsection