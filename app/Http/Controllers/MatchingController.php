<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reaction;
use Auth;
use App\Constants\Status;

class MatchingController extends Controller
{
    //
    public static function index()
    {
        // 自分へlikeしてくれた人のIDを取得
        $got_reaction_ids = Reaction::where([
            ['to_user_id', Auth::id()], // いいねされた人が自分
            ['status', Status::LIKE] // いいねがついている
        ])->pluck('from_user_id'); //pluckを使用する事でID情報のみを取得する事ができる

        // likeしてくれた人の中から自分がlikeした人だけを抽出する
        $matching_ids = Reaction::whereIn('to_user_id', $got_reaction_ids)
        ->where('status', Status::LIKE)
        ->where('from_user_id', Auth::id())
        ->pluck('to_user_id');

        // 相互フォローのユーザー情報を取得
        $matching_users = User::whereIn('id', $matching_ids)->get();

        // 相互フォローの人数を取得
        $matching_users_count = count($matching_users);

        return view('users.index', compact('matching_users', 'matching_users_count'));
    }
}
