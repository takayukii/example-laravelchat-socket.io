<?php

namespace App\Observers;

use App\Message;

class MessageObserver {

    public function saving($model)
    {
        //
    }

    public function saved(Message $model)
    {
        $messages = \App\Message::with('fromUser')->with('toUser')
            ->where('id', $model->id)->get()->toArray();
        event(new \App\Events\MessageCreatedEvent([$model->from_user_id, $model->to_user_id], current($messages)));
    }

}