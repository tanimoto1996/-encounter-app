<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\ChatMessage;
use App\Models\User;

use App\Events\ChatPusher;

use Auth;

class ChatController extends Controller
{
    //
    public static function show(Request $request)
    {
        $matching_user_id = $request->user_id;

        // 自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');

        // 自分の持っているチャットルームから特定の相手がいるルームを探す
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
            ->where('user_id', $matching_user_id) //相手のIDがあるのが条件
            ->pluck('chat_room_id');

        if($chat_room_id->isEmpty()) {
            // チャットルームを作成
            ChatRoom::create();

            // 一番最新に作成されたチャットルームを取得
            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first();

            $chat_room_id = $latest_chat_room->id;

            // 新規登録 fillebleで許可したフィールドを指定して登録
            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => Auth::id()]);

            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => $matching_user_id]);
        }

        // チャットルーム取得時はオブジェクトなので数値に変換する
        if(is_object($chat_room_id)) {
            $chat_room_id = $chat_room_id->first();
        }

        // チャット相手のユーザー情報を取得
        $chat_room_user = User::findOrFail($matching_user_id);

        // チャット相手の名前を取得（jsで使用）
        $chat_room_user_name = $chat_room_user->name;

        // チャットのメッセージを作成日の降順で取得する
        $chat_messages = ChatMessage::where('chat_room_id', $chat_room_id)
        ->orderby('created_at')
        ->get();

        return view('chat.show',
        compact('chat_room_id', 'chat_room_user',
        'chat_messages', 'chat_room_user_name'));
    }

    public static function chat (Request $request)
    {
        $chat = new ChatMessage();
        $chat->chat_room_id = $request->chat_room_id;
        $chat->user_id = $request->user_id;
        $chat->message = $request->message;
        $chat->save();

        event(new ChatPusher($chat));
    }
}
