<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class TicketServiceController extends Controller
{
    protected $global_setting_repository;
    protected $global_table;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository)
    {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->middleware('permission:manage-ticket-service', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-ticket-service', ['only' => ['store']]);
        $this->middleware('permission:edit-ticket-service', ['only`' => ['update']]);
        $this->middleware('permission:delete-ticket-service', ['only' => ['destroy']]);
        $this->global_table = 'ticket_service';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ticket_services = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($ticket_services)
                ->addColumn('name', function ($ticket_service) {
                    return @json_decode($ticket_service->value)->name;
                })
                ->addColumn('action', function ($ticket_service) {
                    return view('ticket_service::includes._index_action', compact('ticket_service'))->render();
                })
                ->toJson();
        } else {
            return view('ticket_service::index');
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
            $ticket_service = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Service has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-service.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $ticket_service = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $ticket_service->value = @json_decode($ticket_service->value);
            if ($ticket_service->value != null && is_object($ticket_service->value)) {
                foreach ($ticket_service->value as $key => $value) {
                    $ticket_service->{$key} = $value;
                }
            }
            unset($ticket_service->value);
            unset($ticket_service->key);
            return response()->json($ticket_service, 200);
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
            $ticket_service = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $ticket_service->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Service has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-service.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Ticket Service has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-service.index')->with($status, $message);
    }
}
