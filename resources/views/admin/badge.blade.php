<?php

//die($questions_ordered);
$page = 0;
if (isset($_GET['page']) && $_GET['page'] > 0)
    $page = $_GET['page'];
$take = 10;


$pages = ceil(count($users->get()) / $take);
$users = $users->skip($page * $take)->take($take)->get();


?>


@extends('layouts.app')
@section('content')
    <div class="container" style="width: 90%; padding-left: 50px; ">
        @foreach($users as $user)
            <div class="media center-block" style="max-width: 300px;">
                <div class="media-left">
                    <a href="#">
                        @if($user->profile_picture)
                            <img class="pp" src="{{asset($user->profile_picture)}}">
                        @else
                            <img class="pp" src="{{asset('art/default_pp.png')}}">
                        @endif
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><a
                                href="{{url('user/'.$user->id)}}">{{$user->first_name.' '.$user->last_name}}</a>
                    </h4>
                    @if($user->verified_badge ==0)
                    <form method="post" action="{{url('admin/add_badge/'.$user->id)}}">
                        <div class="form-group">
                            <div class="col-md-4">
                                <button id="add_badge" name="add_badge" class="btn btn-primary">Add Badge</button>
                            </div>
                        </div>
                    </form>
                    @else
                        <form method="post" action="{{url('admin/remove_badge/'.$user->id)}}">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <button id="add_badge" name="add_badge" class="btn btn-danger">remove Badge</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach


        <nav class="center-block" style="text-align: center">
            <ul class="pagination">
                @if($page > 0)
                    <li><a href="?page={{$page - 1}}" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                @endif
                @for($i = 0; $i < $pages; $i++)
                    @if($page == $i)
                        <li class="active"><a href="?page={{$i}}">{{$i + 1}} <span class="sr-only">(current)</span></a>
                        </li>
                    @else
                        <li><a href="?page={{$i}}">{{$i + 1}}</a></li>
                    @endif

                @endfor
                @if($page < $pages - 1)
                    <li class="{{$page >= $pages-1? 'disabled':''}}"><a href="?page={{$page+1}}" aria-label="Next"><span
                                    aria-hidden="true">»</span></a></li>
                @endif
            </ul>
        </nav>
    </div>

    <style>
        .pp {
            width: 50px;
            height: auto;
            border-radius: 30px;
        }

        .pagination a {
            color: #E66900 !important;
            background-color: #FDF9F3 !important;
        }

        .pagination .active a {
            background-color: #FFAF6C !important;
            border-color: #CC8C39;
            color: #BD5D0D !important;
        }
    </style>
@endsection