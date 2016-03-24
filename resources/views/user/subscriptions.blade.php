@extends('layouts.app');
@section('content')
    <div class="container" style="padding-left:100px">
        <h1>Manage subscriptions</h1>
        <form method="POST" action="">
            {{csrf_field()}}
            <ul>

            @foreach($majors as $major)
                <li><h4>{{$major->major}}</h4>
                    <ul>
                    @for($i = 1; $i <= 10; $i++)
                        @if(count($major->courses()->where('semester','=',$i)->get()))
                                <li>Semester {{$i}}
                                    <br><a class="select_all" href="#" major="{{$major->id}}" semester="{{$i}}">Select all</a>
                                    <ul>
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
@endsection


