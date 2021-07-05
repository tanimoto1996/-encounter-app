<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // レコードを作成する
        DB::table('users')->insert([
            ['name' => 'ジョブズ',
            'email' => 'user1@example.com',
            'sex' => '0',
            'self_introduction' => 'ジョブズです',
            'img_name' => 'sample001.jpg',
            'password' => Hash::make('password123'),
            ],
            ['name' => 'ザッカーバーグ',
            'email' => 'user2@example.com',
            'sex' => '1',
            'self_introduction' => 'ザッカーバーグです',
            'img_name' => 'sample002.jpg',
            'password' => Hash::make('password123'),
            ],
            ['name' => 'ジェフペゾフ',
            'email' => 'user3@example.com',
            'sex' => '0',
            'self_introduction' => 'ジェフですです',
            'img_name' => 'sample003.jpg',
            'password' => Hash::make('password123'),
            ],
            ['name' => 'イーロン',
            'email' => 'user4@example.com',
            'sex' => '0',
            'self_introduction' => 'イーロンです',
            'img_name' => 'sample004.jpg',
            'password' => Hash::make('password123'),
            ],
        ]);
    }
}
