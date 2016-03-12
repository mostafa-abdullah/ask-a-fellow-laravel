<html>
<head>
    <title>
        Ask a fellow
    </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src = "js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src = "js/bootstrap.min.js" ></script>
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


            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Login</a></li>
                <li><a href="#">Register</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<div id="main_content" class="center-block">
    @yield('content')

</div>
<div id="footer"></div>
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
    #footer
    {
        /*margin-top: 5px;*/
        height: 200px;
        width: 100%;
        background-color: #621708;
    }
    #main_content{

        padding-top: 100px;
        padding-bottom: 50px;
        /*height: 800px;*/
        width: 80%;
        background-color: #F7E8D6;
        margin-top: 60px;
        margin-bottom: 10px;
        box-shadow: 0px 5px 10px -1px #888888;
        z-index: 1;
    }
</style>