<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Services\CheckExtensionServices;
use App\Services\FileUploadServices;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('user');
    }

    // 新規登録画面
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    // バリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'img_name' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2000'],
            'self_introduction' => ['string', 'max:255'],
        ]);
    }

    // 登録処理
    protected function create(array $data)
    {

        $fileNameToStore = '';

        if(isset($data['img_name'])) {
            // imgのPOSTを取得
            $imageFile = $data['img_name'];

            // 取得したファイルの情報を変数に代入
            $list = FileUploadServices::fileUpload($imageFile);
            list($extension, $fileNameToStore, $fileData) = $list;

            // 拡張子のチェック
            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);

            //画像アップロード(Imageクラス makeメソッドを使用)
            $image = Image::make($data_url);

            //画像を横400px, 縦400pxにリサイズし保存
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );
        } 

        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'self_introduction' => $data['self_introduction'],
            'sex' => $data['sex'],
            'img_name' => $fileNameToStore,
        ]);
    }
}