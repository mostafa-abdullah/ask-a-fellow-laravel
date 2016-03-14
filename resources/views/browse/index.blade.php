@extends('layouts.app')
@section('content')
    <div class="container" style="text-align: center; width: 100%;">
        <div class="major_and_semester center-block">
            <select id="major" style="" class="form-control">
                @foreach($majors as $major)
                    <option value="{{$major->id}}">{{$major->major}}</option>
                @endforeach
            </select>
            <br>
            <select style="margin-top:30px;" id="semester" class="form-control">
                @foreach($semesters as $semester)
                    <option value="{{$semester}}">{{$semester}}</option>
                @endforeach
            </select>
            <br>
            <a id="show_courses" style="margin-top:30px;"href="#" class="btn btn-info">Show courses</a>
        </div>

        <div class="courses pull-right">

        </div>
    </div>



    <style>
        .major_and_semester
        {
            width: 30%;
        }
        .courses
        {
            /*width: 0;*/
            margin-left: 50px;
        }

    </style>
    <script>
        $('#show_courses').click(function(){
            //send ajax request;
            var major = $('#major').val();
            var semester = $('#semester').val();
            var url = "{{ url('/list_courses') }}";
            $.ajax({
                url: url+'/'+major+'/'+semester,
                success: function(data){
                    $('.major_and_semester').addClass('pull-left');
                    $('.courses').css('width','60%').html(data);

                }

            });
        });
    </script>

@endsection