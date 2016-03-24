<html>
<head>
    <title>
        Ask a fellow
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src = "{{asset('js/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src = "{{asset('js/bootstrap.min.js')}}" ></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">Ask a Fellow</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{url('/home')}}">Home</a></li>
                <!-- <li class="link-separator"><a>|</a></li> -->
                <li><a href="{{url('/about')}}">About</a></li>
                <!-- <li class="link-separator"><a>|</a></li> -->
                <li><a href="{{url('/how_it_works')}}">How it works</a></li>
            </ul>
            <form method="get" action="" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input id="search_bar" style="width: 300px;" name="key" type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" id="search_button" class="btn btn-default">Search</button>
            </form>

            @if(Auth::user())
                <ul class="nav navbar-nav navbar-right">
                    <li><a id="view_notifications" data-toggle="modal" data-target="#notifications_modal" title="{{count(Auth::user()->new_notifications)}} new notifications" href="#"><span style="font-size:20px; color:{{ count(Auth::user()->new_notifications)?'#D61919':'White'  }}" class="glyphicon glyphicon-bell">{{(count(Auth::user()->new_notifications))?count(Auth::user()->new_notifications):''}}</span></a></li>
                    <li class="dropdown" >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->first_name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu" style="background-color: #FFAF6C;">
                            <li><a href="{{url('user/'.Auth::user()->id)}}">Profile</a></li>

                            @if(Auth::user()->role > 0)
                                <li><a href="{{url('/admin/feedbacks')}}">View Feedbacks</a></li>
                                <li><a href="{{url('/admin')}}">Admin Roles</a></li>
                            @endif
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('/logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{url('/login')}}">Login</a></li>
                    <li><a href="{{url('/register')}}">Register</a></li>
                </ul>
            @endif

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>





<div id="main_content" class="center-block">
    @if (session('feedback'))
        <div class="flash-message">
            <div class="alert alert-success" style="margin-left: 30px; margin-right: 30px;text-align: center;">
                {{session('feedback')}}
            </div>
        </div>
    @endif
    @include('errors')
    @yield('content')

</div>
@if(Auth::user())
    <div id="notifications_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class=""  style="background-color:rgba(255,255,255,0.8)">

                <button style="margin-right:15px;margin:top:10px;"type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>

                <br>
                <div class="modal-body" style="text-align:center">
                    <h3>Notifications </h3>
                    <div id="list_notifications">

                    </div>

                    <br>


                </div>
                <!-- <div class="modal-footer"> -->

                <!-- </div> -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endif
@include('layouts.footer')
</body>
</html>




<style>
    .navbar
    {
        box-shadow: 0px 1px 5px #888888;
        position: fixed;
        width: 100%;
        top: 0;
        background-color: #FFAF6C !important;
        /*background-color: #FF953D !important;*/
        margin-bottom: 0px;
        border: none;
        /*padding: 20px;*/
        /*height: 100px;*/
        z-index: 20;
    }
    .navbar .active a
    {
        background-color: #FFA83E !important;


    }
    .navbar a
    {
        color: white !important;
        font-size: 16px;

    }
    .link-separator a:hover
    {
        background-color: #FFE9CF !important;
    }

    .navbar ul a:hover
    {

        background-color: #FF9E28 !important;
    }

    .navbar .navbar-brand
    {
        font-size: 25px;
    }
    .navbar #search_bar
    {
        background-color: #FFE9CF;

        width: 300px;
    }

    .navbar #search_button
    {
        background-color: #FFE9CF;
        z-index: 5;
    }

    #main_content{

        padding-top: 100px;
        padding-bottom: 50px;


        min-height: 500px;
        width: 80%;
        background-color: #FFFAF4;
        margin-top: 60px;
        margin-bottom: 10px;
        /*box-shadow: 0px 5px 10px -1px #888888;*/
        z-index: 1;
    }

    @media (min-width:777px) and (max-width: 1000px) {
        .navbar ul.navbar-left
        {
            display: none;
        }
    }


</style>
<script>
    $('#view_notifications').click(function(){
        $.ajax({
           'url' : "{{url('/notifications_partial')}}",
            success : function(data){
                $('#list_notifications').html(data);
            }
        });
    });
</script>