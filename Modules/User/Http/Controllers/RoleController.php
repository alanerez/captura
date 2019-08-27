<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\User\Interfaces\PermissionRepositoryInterface;
use Modules\User\Interfaces\RoleRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    protected $role_repository;
    protected $permission_repository;

    public function __construct(RoleRepositoryInterface $role_repository, PermissionRepositoryInterface $permission_repository)
    {
        $this->role_repository = $role_repository->model;
        $this->permission_repository = $permission_repository->model;
        $this->middleware('permission:manage-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-role', ['only' => ['store']]);
        $this->middleware('permission:edit-role', ['only`' => ['update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = $this->role_repository->select(['id', 'name'])->get();
            return Datatables::of($roles)
                ->addColumn('action', function ($role) {
                    return view('role::includes._index_action', compact('role'))->render();
                })
                ->toJson();
        } else {
            $permissions = $this->permission_repository->all();
            return view('role::index', compact('permissions'));
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
            $role = $this->role_repository->create($data);
            $role->perms()->sync($data['permissions']);
            DB::commit();
            $status = 'success';
            $message = 'Role has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('role.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $role = $this->role_repository->find($id);
            $role->permissions = $role->perms()->pluck('id')->toArray();
            return response()->json($role, 200);
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
            $role = $this->role_repository->findOrFail($id);
            $role->update($data);
            $role->perms()->sync($data['permissions']);
            DB::commit();
            $status = 'success';
            $message = 'Role has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('role.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->role_repository->destroy($id);
            $status = 'success';
            $message = 'Role has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('role.index')->with($status, $message);
    }
}
