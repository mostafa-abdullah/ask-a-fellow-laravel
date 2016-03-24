@extends('layouts.app')
@section('content')
<div class="container" style="width: 90%">
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th style="width: 50%;">Feedback</th>
        </tr>
        @foreach($feedbacks as $feedback)
            <tr>
                <td>{{$feedback->name}}</td>
                <td>{{$feedback->email}}</td>
                <td>{{$feedback->feedback}}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection