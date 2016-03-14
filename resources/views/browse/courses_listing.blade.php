

<table class="table table-hover">
    <tr id="head">
        <th>Course code</th>
        <th>Course name</th>
        <th>Questions</th>
    </tr>
    @foreach($courses as $course)
        <tr href="{{url('browse/'.$course->id)}}">

                <td>{{$course->course_code}}</td>
                <td>{{$course->course_name}}</td>
                <td>{{count($course->questions()->get())}}</td>

        </tr>
    @endforeach
</table>

<style>
    .table{
        box-shadow: none;
        border: 1px solid #FFAF6C;
        border-collapse: separate;
    }
    .table td
    {
        border-top: 1px solid #FFAF6C;
        cursor: pointer;
    }
    .table th
    {
        border-bottom: 1px solid #FFAF6C;
    }
</style>
