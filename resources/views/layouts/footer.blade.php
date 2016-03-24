<div id="footer">
    <div class="container" >
        <h3>Ask a Fellow</h3>
        <div class="col-md-4">

            <ul>
                <li>
                    <a href="{{url('/')}}">Home</a>
                </li>
                <li>
                    <a href="{{url('/about')}}">About</a>
                </li>
                <li>
                    <a href="{{url('/how_it_works')}}">How it works</a>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <a href="{{url('/browse')}}">Browse Courses</a>
                </li>
                <li>
                    <a href="{{url('/subscriptions')}}">Subscribe</a>
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <a href="mailto:mostafaabdullahahmed@gmail.com?subject=Ask a Fellow">Contact us</a>
                </li>
                <li>
                    <a >Send Feedback</a>
                </li>

            </ul>
        </div>

    </div>

</div>
<div id="rights">
    All rights reserved. Proudly created by <span style="color:cornflowerblue">Bdaya TechHub</span>
    <br>
    <a target="_blank" href="https://www.facebook.com/BdayaNGO"><img class="contact_logo" src="{{asset('/art/facebook.png')}}"></a>
    <a target="_blank" href="https://www.youtube.com/user/salfoosh"><img class="contact_logo" src="{{asset('/art/youtube.png')}}"></a>
    <a target="_blank" href="https://www.instagram.com/bdaya_ngo/"><img class="contact_logo" src="{{asset('/art/instagram.png')}}"></a>
    <a target="_blank" href="https://github.com/mostafa-abdullah/ask-a-fellow-laravel"><img class="contact_logo" src="{{asset('/art/github.png')}}"></a>
</div>

<style>
    .contact_logo
    {
        margin-top: 20px;
        margin-left: 5px;
        margin-right: 5px;
        height: 30px;

    }
    #footer
    {
        /*margin-top: 5px;*/
        color:#FFAF6C;
        height: 200px;
        width: 100%;
        background-color: #621708;
        padding:25px;

    }
    #footer a
    {
        color:#FFAF6C;
        font-size: 16px;
        cursor: pointer;
    }
    #footer a:hover, #footer a:focus
    {
        text-decoration: none;
        color:#FFFF6C;

    }
    #rights{

        background-color: #9A4838;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        color:white;
    }

    #footer li
    {
        list-style-type: none;
    }
</style>