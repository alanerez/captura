<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Core\Services\ColorService;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class TicketStatusController extends Controller {
    protected $global_setting_repository;
    protected $global_table;
    protected $color_service;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository, ColorService $color_service) {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->color_service = $color_service;
        $this->middleware('permission:manage-ticket-status', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-ticket-status', ['only' => ['store']]);
        $this->middleware('permission:edit-ticket-status', ['only`' => ['update']]);
        $this->middleware('permission:delete-ticket-status', ['only' => ['destroy']]);
        $this->global_table = 'ticket_status';
    }

    public function index(Request $request) {
        if ($request->ajax()) {
            $ticket_statuses = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($ticket_statuses)
                ->addColumn('name', function ($ticket_status) {
                    return @json_decode($ticket_status->value)->name;
                })
                ->addColumn('color', function ($ticket_status) {
                    $color = @json_decode($ticket_status->value)->color;
                    $text_color = $this->color_service->getTextColor($color);
                    return view('ticket_status::includes._color', compact('color', 'text_color'))->render();
                })
                ->addColumn('action', function ($ticket_status) {
                    return view('ticket_status::includes._index_action', compact('ticket_status'))->render();
                })
                ->rawColumns(['color', 'action'])
                ->toJson();
        } else {
            return view('ticket_status::index');
        }
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data['key'] = $this->global_table;
            $data['value'] = json_encode($data['value']);
            $ticket_status = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Status has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-status.index')->with($status, $message);
    }

    public function show(Request $request, $id) {
        if ($request->ajax()) {
            $ticket_status = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $ticket_status->value = @json_decode($ticket_status->value);
            if ($ticket_status->value != null && is_object($ticket_status->value)) {
                foreach ($ticket_status->value as $key => $value) {
                    $ticket_status->{$key} = $value;
                }
            }
            unset($ticket_status->value);
            unset($ticket_status->key);
            return response()->json($ticket_status, 200);
        } else {
            return;
        }
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data['value'] = json_encode($data['value']);
            $ticket_status = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $ticket_status->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Status has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-status.index')->with($status, $message);
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Ticket Status has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-status.index')->with($status, $message);
    }
}
