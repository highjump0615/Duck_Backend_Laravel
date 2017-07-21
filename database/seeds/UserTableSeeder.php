<?php

use App\Model\User;
use App\Model\Role;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    protected $table = 'users';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 添加角色
        $role = Role::create([
            'name' => '超级管理员'
        ]);

        User::create([
            'username' => 'admin',
            'email' => 'test@email.com',
            'role_id' => $role->id,
            'password' => bcrypt('root'),
        ]);
    }
}
