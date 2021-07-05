<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    // createメソッドで新規作成する場合は、フィールドを指定しておく
    protected $fillable = ['chat_room_id', 'user_id', 'message'];

    public function chatRoom()
    {
        return $this->BelongsTo('App\Models\ChatRoom');
    }

    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }
}
