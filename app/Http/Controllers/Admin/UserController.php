<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'keyword']);
        $users = $this->users->getAll($filters);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'role_id'  => 'required|integer',
            'status'   => 'required|string',
        ]);

        $this->users->create($data);

        return redirect()->route('admin.users.index')->with('success', 'Tạo user thành công');
    }

    public function show($id)
    {
        $user = $this->users->find($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->users->find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
            'role_id'  => 'required|integer',
            'status'   => 'required|string',
        ]);

        $this->users->update($id, $data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công');
    }

    public function destroy($id)
    {
        $this->users->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'Xóa user thành công');
    }
}
