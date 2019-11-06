<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role')
            ->select('users.*', 'roles.name AS role_name')
            ->get();

        $roles = DB::table('roles')->get();
        return view('pages.users', ['users' => $users, 'roles' => $roles]);
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $role = $request->input('role');

        DB::table('users')->where('id', $id)->update(['name' => $name, 'email' => $email, 'role' => $role]);

        return redirect()->action('UsersController@index');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        DB::table('users')->where('id', $id)->delete();

        return redirect()->action('UsersController@index');
    }
}
