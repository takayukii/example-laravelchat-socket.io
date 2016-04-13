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
                                <label for="sel1">To</label>
                                <select class="form-control" id="sel1">
                                    @foreach($users as $user)
                                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Say something..."/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">Send!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <ul>
                        @foreach($messages as $message)
                        <li>{{ $message['message'] }} by {{ $message['from_user']['name'] }} at {{ $message['created_at']->format('Y-m-d H:i:s') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
