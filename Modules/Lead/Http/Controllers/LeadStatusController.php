<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Core\Services\ColorService;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class LeadStatusController extends Controller
{
    protected $global_setting_repository;
    protected $global_table;
    protected $color_service;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository, ColorService $color_service)
    {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->color_service = $color_service;
        $this->middleware('permission:manage-lead-status', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-lead-status', ['only' => ['store']]);
        $this->middleware('permission:edit-lead-status', ['only`' => ['update']]);
        $this->middleware('permission:delete-lead-status', ['only' => ['destroy']]);
        $this->global_table = 'lead_status';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lead_statuses = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($lead_statuses)
                ->addColumn('name', function ($lead_status) {
                    return @json_decode($lead_status->value)->name;
                })
                ->addColumn('color', function ($lead_status) {
                    $color = @json_decode($lead_status->value)->color;
                    $text_color = $this->color_service->getTextColor($color);
                    return view('lead_status::includes._color', compact('color', 'text_color'))->render();
                })
                ->addColumn('action', function ($lead_status) {
                    return view('lead_status::includes._index_action', compact('lead_status'))->render();
                })
                ->rawColumns(['color', 'action'])
                ->toJson();
        } else {
            return view('lead_status::index');
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
            $lead_status = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Status has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-status.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $lead_status = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $lead_status->value = @json_decode($lead_status->value);
            if ($lead_status->value != null && is_object($lead_status->value)) {
                foreach ($lead_status->value as $key => $value) {
                    $lead_status->{$key} = $value;
                }
            }
            unset($lead_status->value);
            unset($lead_status->key);
            return response()->json($lead_status, 200);
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
            $lead_status = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $lead_status->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead Status has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-status.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Lead Status has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead-status.index')->with($status, $message);
    }
}
