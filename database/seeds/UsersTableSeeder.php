<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User();
        $u->role_id = 1;
        $u->name = 'ijin82';
        $u->email = 'ilya.rogojin@gmail.com';
        $u->email_verified_at = date('Y-m-d H:i:s');
        $u->password = \Hash::make('qwe123');
        $u->save();
    }
}
