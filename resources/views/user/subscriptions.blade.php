@extends('layouts.app');
@section('content')
    <div class="container" style="padding-left:100px; width:100%;">
        <h1>Manage subscriptions</h1>
        <form method="POST" action="">
            {{csrf_field()}}
            <ul>

            @foreach($majors as $major)
                <li><h4><a class="select_major" data-toggle="collapse" href="#semesters_{{$major->id}}" aria-expanded="false" aria-controls="semesters_{{$major->id}}">{{$major->major}}</a></h4>
                    <ul id="semesters_{{$major->id}}" class="collapse">
                    @for($i = 1; $i <= 10; $i++)
                        @if(count($major->courses()->where('semester','=',$i)->get()))
                                <li><a class="select_semester" data-toggle="collapse" href="#courses_{{$major->id}}_{{$i}}" aria-expanded="false" aria-controls="courses_{{$major->id}}_{{$i}}">Semester {{$i}}</a>

                                    <ul id="courses_{{$major->id}}_{{$i}}" class="collapse">
                                        <br><a class="select_all" href="#" major="{{$major->id}}" semester="{{$i}}">Select all</a>
                                        @foreach($major->courses()->where('semester','=',$i)->get() as $course)
                                            <li>
                                                <input {{ (in_array($course->id,$subscribed_courses))?'checked':'' }} value="{{$course->id}}" type="checkbox" name="course[]" class="select_course course_{{$course->id}}">
                                                {{$course->course_name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif

                     @endfor
                    </ul>
                </li>
            @endforeach

            </ul>
            <input type="submit" class="btn btn-warning">
        </form>
    </div>


    <script>
        $('.select_all').click(function(){
            $(this).parent().find('input').attr('checked',true);
        });


        $('.select_course').change(function() {
            var course_id = $(this).val();
            $('.course_'+course_id).prop('checked',this.checked);
        });
    </script>

    <style>
        .select_major, .select_semester{
            color: #9A4838;
        }

        .select_major:hover, .select_semester:hover, .select_major:focus, .select_semester:focus{
            text-decoration: none;
        }
    </style>
@endsection


