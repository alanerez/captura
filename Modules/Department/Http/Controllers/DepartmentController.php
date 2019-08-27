<?php

namespace Modules\Department\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Department\Entities\Department;
use Modules\Department\Interfaces\DepartmentRepositoryInterface;
use Modules\Department\Interfaces\EmailRepositoryInterface;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    protected $department_repository;
    protected $global_setting_repository;
    protected $email_repository;

    public function __construct(
        DepartmentRepositoryInterface $department_repository,
        GlobalSettingRepositoryInterface $global_setting_repository,
        EmailRepositoryInterface $email_repository
    ) {
        $this->department_repository = $department_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
        $this->email_repository = $email_repository->model;
        $this->middleware('permission:manage-department', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-department', ['only' => ['store']]);
        $this->middleware('permission:edit-department', ['only`' => ['update']]);
        $this->middleware('permission:delete-department', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = $this->department_repository->select([
                'id',
                'name',
            ])->get();
            return Datatables::of($departments)
                ->addColumn('action', function ($department) {
                    return view('department::includes._index_action', compact('department'))->render();
                })
                ->toJson();
        } else {
            return view('department::index');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $port_list = config('imap.ports');
        $data['incoming_port'] = $port_list[$data['incoming_protocol']][$data['incoming_encryption']];
        $data['outgoing_port'] = $port_list['smtp'][$data['outgoing_encryption']];

        if (isset($data['incoming_validate_cert'])) {
            $data['incoming_validate_cert'] = true;
        } else {
            $data['incoming_validate_cert'] = false;
        }

        try {
            DB::beginTransaction();
            $department = $this->department_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Department has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('department.index')->with($status, $message);
    }

    public function saveNew(Request $request)
    {
        $data = $request->all();
        $port_list = config('imap.ports');
        $data['incoming_port'] = $port_list[$data['incoming_protocol']][$data['incoming_encryption']];
        $data['outgoing_port'] = $port_list['smtp'][$data['outgoing_encryption']];

        if (isset($data['incoming_validate_cert'])) {
            $data['incoming_validate_cert'] = true;
        } else {
            $data['incoming_validate_cert'] = false;
        }


        try {
            DB::beginTransaction();
            $department = $this->department_repository->create($data);
            DB::commit();
            $latest = Department::orderBy('updated_at', 'desc')->first();

            return response()->json($latest);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $department = $this->department_repository->find($id);
            return response()->json($department, 200);
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

        $port_list = config('imap.ports');
        $data['incoming_port'] = $port_list[$data['incoming_protocol']][$data['incoming_encryption']];
        $data['outgoing_port'] = $port_list['smtp'][$data['outgoing_encryption']];

        if (isset($data['incoming_validate_cert'])) {
            $data['incoming_validate_cert'] = true;
        } else {
            $data['incoming_validate_cert'] = false;
        }

        try {
            DB::beginTransaction();
            $department = $this->department_repository->findOrFail($id);
            $department->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Department has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('department.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->department_repository->destroy($id);
            $status = 'success';
            $message = 'Department has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('department.index')->with($status, $message);
    }

}
