@extends('layouts.app')

@section('content')
    <div class="container" style="width:90%; padding-left: 50px;">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/zf/dt-1.10.11/datatables.min.css"/>
        <table id="mails_table" class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        Sender
                    </th>
                    <th>
                        Mail subject
                    </th>
                    <th>
                        Mail Body
                    </th>
                    <th>
                        Recipients
                    </th>
                    <th>
                        Date
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($mails as $mail)
                    <tr>
                        <td><a href="{{url('/user/'.$mail->sender->id)}}">{{$mail->sender->first_name.' '.$mail->sender->last_name}}</a></td>
                        <td>{{$mail->subject}}</td>
                        <td>{!! $mail->body !!}</td>
                        <td>
                            <ul>
                                @foreach($mail->recipients as $rec)
                                    <li><a href="{{url('user/'.$rec->id)}}">{{$rec->first_name.' '.$rec->last_name}}</a></li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$mail->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="https://cdn.datatables.net/t/zf/dt-1.10.11/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#mails_table').DataTable();
        } );
    </script>
@endsection