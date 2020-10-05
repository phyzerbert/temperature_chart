<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getAll(Request $request) {
        $data = [
            'status' => 200,
            'data' => User::where('role', 'user')->orderBy('name')->get(),
        ];
        return response()->json($data);
    }

    public function index(Request $request) {
        $mod = new User();
        if(auth()->user()->role == 'admin') {
            $mod = $mod->where('role', 'user');
        }
        $keyword = '';
        if($request->get('keyword') != '') {
            $keyword = $request->get('keyword');
            $mod = $mod->where(function($query) use($keyword) {
                return $query->where('name', 'like', "%$keyword%")
                            ->orWhere('username', 'like', "%$keyword%")
                            ->orWhere('employee_id', 'like', "%$keyword%");
            });
        }
        $data = $mod->orderBy('name')->paginate(15);
        return view('user', compact('data', 'keyword'));
    }

    public function create_admin(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'role' => 'admin',
            'password' => bcrypt($request->get('password')),
        ]);
        return back()->with('success', 'Created Successfully!');
    }

    public function update(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string',
        ]);

        $user = User::find($request->get('id'));
        $user->username = $request->get('username');
        if($request->get('password') != '') {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();
        return back()->with('success', 'Updated Successfully!');        
    }

    public function delete($id) {
        $item = User::find($id);
        $item->temperatures()->delete();
        $item->delete();
        return back()->with('success', 'Deleted Successfully!');
    }


}
