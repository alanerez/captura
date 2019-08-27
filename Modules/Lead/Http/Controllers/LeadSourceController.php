<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class LeadSourceController extends Controller
{
    protected $global_setting_repository;
    protected $global_table;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository)
    {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->middleware('permission:manage-lead-source', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-lead-source', ['only' => ['store']]);
        $this->middleware('permission:edit-lead-source', ['only`' => ['update']]);
        $this->middleware('permission:delete-lead-source', ['only' => ['destroy']]);
        $this->global_table = 'lead_source';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lead_sources = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($lead_sources)
                ->addColumn('name', function ($lead_source) {
                    return @json_decode($lead_source->value)->name;
                })
                ->addColumn('action', function ($lead_source) {
                    return view('lead_source::includes._index_action', compact('lead_source'))->render();
                })
                ->toJson();
        } else {
            return view('lead_source::index');
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
            $lead_source = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Source has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-source.index')->with($status, $message);
    }

    public function saveNew(Request $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data['key'] = $this->global_table;
            $data['value'] = json_encode($data['value']);
            $lead_source = $this->global_setting_repository->create($data);
            DB::commit();
            $latest = $this->global_setting_repository->where('key', 'lead_source')->orderBy('updated_at', 'desc')->first();
            return response()->json($latest);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $lead_source = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $lead_source->value = @json_decode($lead_source->value);
            if ($lead_source->value != null && is_object($lead_source->value)) {
                foreach ($lead_source->value as $key => $value) {
                    $lead_source->{$key} = $value;
                }
            }
            unset($lead_source->value);
            unset($lead_source->key);
            return response()->json($lead_source, 200);
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
            $lead_source = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $lead_source->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Source has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-source.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Lead Source has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-source.index')->with($status, $message);
    }
}
