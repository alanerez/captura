<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;

class TicketPriorityController extends Controller
{
    protected $global_setting_repository;
    protected $global_table;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository)
    {
        $this->global_setting_repository = $global_setting_repository->model;
        $this->middleware('permission:manage-ticket-priority', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-ticket-priority', ['only' => ['store']]);
        $this->middleware('permission:edit-ticket-priority', ['only`' => ['update']]);
        $this->middleware('permission:delete-ticket-priority', ['only' => ['destroy']]);
        $this->global_table = 'ticket_priority';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ticket_priorities = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->select(['id', 'value'])
                ->get();
            return Datatables::of($ticket_priorities)
                ->addColumn('name', function ($ticket_priority) {
                    return @json_decode($ticket_priority->value)->name;
                })
                ->addColumn('action', function ($ticket_priority) {
                    return view('ticket_priority::includes._index_action', compact('ticket_priority'))->render();
                })
                ->toJson();
        } else {
            return view('ticket_priority::index');
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
            $ticket_priority = $this->global_setting_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Priority has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-priority.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $ticket_priority = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->find($id);
            $ticket_priority->value = @json_decode($ticket_priority->value);
            if ($ticket_priority->value != null && is_object($ticket_priority->value)) {
                foreach ($ticket_priority->value as $key => $value) {
                    $ticket_priority->{$key} = $value;
                }
            }
            unset($ticket_priority->value);
            unset($ticket_priority->key);
            return response()->json($ticket_priority, 200);
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
            $ticket_priority = $this->global_setting_repository
                ->where('key', $this->global_table)
                ->findOrFail($id);
            $ticket_priority->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket Priority has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-priority.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->global_setting_repository
                ->destroy($id);
            $status = 'success';
            $message = 'Ticket Priority has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket-priority.index')->with($status, $message);
    }
}
