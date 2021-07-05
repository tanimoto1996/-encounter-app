<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    // リレーション（関係）を紐づける事ができる
    public function chatRoomUsers()
    {
        // チャットルームのユーザー情報を紐づける
        return $this->hasMany('App\Models\ChatRoomUser');
    }

    public function chatMessages()
    {
        // メッセージと紐づける
        return $this->hasMany('App\Models\ChatMessage');
    }
}
