<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\User\Interfaces\PermissionRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    protected $permission_repository;

    public function __construct(PermissionRepositoryInterface $permission_repository)
    {
        $this->permission_repository = $permission_repository->model;
        $this->middleware('permission:manage-permission', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-permission', ['only' => ['store']]);
        $this->middleware('permission:edit-permission', ['only`' => ['update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = $this->permission_repository->select(['id', 'name'])->get();
            return Datatables::of($permissions)
                ->addColumn('action', function ($permission) {
                    return view('permission::includes._index_action', compact('permission'))->render();
                })
                ->toJson();
        } else {
            return view('permission::index');
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
            $permission = $this->permission_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Permission has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('permission.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $permission = $this->permission_repository->find($id);
            return response()->json($permission, 200);
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
            $permission = $this->permission_repository->findOrFail($id);
            $permission->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Permission has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('permission.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->permission_repository->destroy($id);
            $status = 'success';
            $message = 'Permission has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('permission.index')->with($status, $message);
    }
}
