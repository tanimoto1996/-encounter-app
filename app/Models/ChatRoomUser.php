<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRoomUser extends Model
{
    // createメソッドで新規作成する場合は、フィールドを指定しておく
    protected $fillable = ['chat_room_id', 'user_id'];

    public function chatRoom()
    {
        return $this->BelongsTo('App\Models\ChatRoom');
    }

    public function chatMessage()
    {
        return $this->BelongsTo('App\Models\ChatMessage');
    }
}
