<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\User\Interfaces\RoleRepositoryInterface;
use Modules\User\Interfaces\UserRepositoryInterface;
use Modules\User\Services\UserService;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user_repository;
    protected $role_repository;
    protected $user_service;

    public function __construct(
        UserRepositoryInterface $user_repository,
        UserService $user_service,
        RoleRepositoryInterface $role_repository) {
        $this->user_repository = $user_repository->model;
        $this->role_repository = $role_repository->model;
        $this->user_service = $user_service;
        $this->middleware('permission:manage-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-user', ['only' => ['store']]);
        $this->middleware('permission:edit-user', ['only' => ['update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = $this->user_repository->select(['id', 'first_name', 'last_name', 'middle_name', 'email', 'username', 'profile_picture'])->get();
            return Datatables::of($users)
                ->editColumn('profile_picture', function ($info) {
                    return view('includes._profile_picture', compact('info'))->render();
                })
                ->addColumn('role', function ($user) {
                    $roles = $user->roles;
                    return view('user::includes._role', compact('roles'))->render();
                })
                ->addColumn('action', function ($user) {
                    return view('user::includes._index_action', compact('user'))->render();
                })
                ->rawColumns(['profile_picture', 'role', 'action'])
                ->toJson();
        } else {
            $roles = $this->role_repository->all();
            return view('user::index', compact('roles'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data['created_by'] = auth()->id();
            $password_generated = config('core.password_generated');
            $data['username'] = $password_generated;
            $data['password'] = bcrypt($password_generated);
            $user = $this->user_repository->create($data);
            $user->roles()->sync($data['roles']);
            $this->user_service->saveAllUserSettings($data, $user->id);
            DB::commit();
            $status = 'success';
            $message = 'User has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('user.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = $this->user_repository->find($id);
            $user->roles = $user->roles()->pluck('id')->toArray();
            return response()->json($user, 200);
        } else {
            return;
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $user = $this->user_repository->findOrFail($id);
            $user->update($data);
            $user->roles()->sync($data['roles']);
            $this->user_service->saveAllUserSettings($data, $user->id);
            DB::commit();
            $status = 'success';
            $message = 'User has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('user.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->user_repository->destroy($id);
            $status = 'success';
            $message = 'User has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('user.index')->with($status, $message);
    }
}
