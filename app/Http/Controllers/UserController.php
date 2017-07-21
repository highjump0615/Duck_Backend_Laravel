<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $menu = 'user';
    public $viewBaseParams;

    public function __construct()
    {
        $this->viewBaseParams = ['menu' => $this->menu];
    }

    /**
     * 打开用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserList(Request $request) {
        $users = User::get();

        return view('user.list', array_merge($this->viewBaseParams, [
            'page' => $this->menu . '.list',

            // 数据
            'users' => $users,
        ]));
    }

    /**
     * 设置基础信息
     * @return array
     */
    private function getBaseData() {
        $roles = Role::orderBy('id', 'desc')->get();

        return ['roles' => $roles];
    }

    /**
     * 打开详细内容
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdd(Request $request) {
        return view('user.detail', $this->getBaseData());
    }

    /**
     * 打开修改
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetail(Request $request, $id) {
        $user = User::find($id);

        return view('user.detail', array_merge($this->getBaseData(), [
            'user' => $user,
        ]));
    }

    /**
     * 保存用户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUser(Request $request) {
        $nUserId = 0;
        if (!empty($request->input('userid'))) {
            $nUserId = $request->input('userid');
        }

        if ($nUserId > 0) {
            $user = User::find($nUserId);
        }
        else {
            $user = new User();
        }

        $user->username = $request->input('username');
        $user->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->role_id = $request->input('role');
        $user->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * 删除用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request, $id) {
        User::find($id)->delete();

        return response()->json(['status' => 'success']);
    }
}
