<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id', 'to_user_id', 'message',
    ];

    public function fromUser()
    {
        return $this->belongsTo('App\User');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeRelated($query, $userId1, $userId2)
    {
        $query->where(function ($_query) use ($userId1) {
            $_query->where('from_user_id', $userId1)->orWhere('to_user_id', $userId1);
        })
        ->where(function ($_query) use ($userId2) {
            $_query->where('from_user_id', $userId2)->orWhere('to_user_id', $userId2);
        });
    }
}
