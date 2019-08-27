<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Core\Services\ColorService;
use Modules\GlobalSetting\Entities\GlobalSetting;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class LeadTypeController extends Controller
{
    protected $global_setting_repository;
    protected $global_table;
    protected $color_service;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository, ColorService $color_service)
    {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->middleware('permission:manage-lead-type', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-lead-type', ['only' => ['store']]);
        $this->middleware('permission:edit-lead-type', ['only`' => ['update']]);
        $this->middleware('permission:delete-lead-type', ['only' => ['destroy']]);
        $this->global_table = 'lead_type';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lead_types = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($lead_types)
                ->addColumn('name', function ($lead_type) {
                    return @json_decode($lead_type->value)->name;
                })
                ->addColumn('action', function ($lead_type) {
                    return view('lead_type::includes._index_action', compact('lead_type'))->render();
                })
                ->toJson();
        } else {
            return view('lead_type::index');
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
            $data['key'] = $this->global_table;
            $data['value'] = json_encode($data['value']);
            $lead_type = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Type has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-type.index')->with($status, $message);
    }

    public function saveNew(Request $request)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();
            $data['key'] = $this->global_table;
            $data['value'] = json_encode($data['value']);
            $lead_type = $this->global_setting_repository->create($data);
            DB::commit();
            $latest = $this->global_setting_repository->where('key', "lead_type")->orderBy('updated_at', 'desc')->first();
            return response()->json($latest);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $lead_type = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $lead_type->value = @json_decode($lead_type->value);
            if ($lead_type->value != null && is_object($lead_type->value)) {
                foreach ($lead_type->value as $key => $value) {
                    $lead_type->{$key} = $value;
                }
            }
            unset($lead_type->value);
            unset($lead_type->key);
            return response()->json($lead_type, 200);
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
            $data['value'] = json_encode($data['value']);
            $lead_type = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $lead_type->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Type has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-type.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Lead Type has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-type.index')->with($status, $message);
    }
}
