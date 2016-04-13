@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Chat</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="selectTo">To</label>
                                <select id="selectTo" class="form-control">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <div class="input-group">
                                    <input id="textMessage" type="text" class="form-control" placeholder="Say something..."/>
                                    <span class="input-group-btn">
                                        <button id="btnSend" class="btn btn-primary" type="button">Send!</button>
                                    </span>
                                </div>
                            </div>
                            <input id="csrfToken" type="hidden" name="csrf-token" value="{{ csrf_token() }}"/>
                        </div>
                    </div>
                    <hr/>
                    <ul id="ulMessages">
                        @foreach($messages as $message)
                        <li>{{ $message->message }} by {{ $message->fromUser->name }} at {{ $message->created_at }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
