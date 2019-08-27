<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Core\Services\ColorService;
use Modules\Department\Entities\EmailReply;
use Modules\Department\Interfaces\DepartmentRepositoryInterface;
use Modules\Department\Interfaces\EmailRepositoryInterface;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Modules\Ticket\Entities\Ticket;

class TicketController extends Controller
{
    protected $email_repository;
    protected $global_setting_repository;
    protected $department_repository;
    protected $color_service;

    public function __construct(
        EmailRepositoryInterface $email_repository,
            GlobalSettingRepositoryInterface $global_setting_repository,
        ColorService $color_service,
        DepartmentRepositoryInterface $department_repository
    ) {
        $this->email_repository = $email_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
        $this->department_repository = $department_repository->model;
        $this->color_service = $color_service;
        $this->middleware('permission:manage-ticket', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-ticket', ['only' => ['store']]);
        $this->middleware('permission:edit-ticket', ['only`' => ['update']]);
        $this->middleware('permission:delete-ticket', ['only' => ['destroy']]);
    }

    private function getReferenceID($ref)
    {
        $references = explode(' ', $ref);
        $string = substr($references[0], 1, -1);
        return $string;
    }

    public function index(Request $request)
    {
        $tickets = $this->email_repository;

        $ticket_count = $this->email_repository;
        $replies = EmailReply::where('department_id', $request->department_id)->get();

        if ($request->department_id) {
            $ticket_count = $ticket_count->where('department_id', $request->department_id);
            $tickets = $tickets->where('department_id', $request->department_id);
        }

        if ($request->status_id) {
            $ticket_count = $ticket_count->where('status_id', $request->status_id);
            $tickets = $tickets->where('status_id', $request->status_id);
        }

        $ticket_count = $ticket_count
            ->where('department_id', $request->department_id)
            ->count();

        $tickets = $tickets
            ->where('department_id', $request->department_id)
            ->orderBy('date', 'desc')
            ->simplePaginate(50);

        foreach ($tickets as $ticket) {

            $ticket->childs = $this->email_repository->where('references', 'like', '%' . $ticket->message_id . '%')->get();

        }

        $departments = $this->department_repository->all();

        $ticket_statuses_query = $this->global_setting_repository
            ->where('key', 'ticket_status')
            ->get();

        $ticket_statuses = [];

        foreach ($ticket_statuses_query as $key => $value) {
            $ticket_statuses[$value->id]['name'] = json_decode($value->value)->name;
            $ticket_statuses[$value->id]['color'] = json_decode($value->value)->color;
            $ticket_statuses[$value->id]['text_color'] = $this->color_service->getTextColor($ticket_statuses[$value->id]['color']) == 'text-light' ? 'white' : 'black';
        }

        return view('ticket::index', compact('tickets', 'ticket_statuses', 'departments', 'ticket_count', 'replies'));

        // if ($request->ajax()) {
        //     $tickets = $this->email_repository->select([
        //         'subject',
        //         'description',
        //         'priority',
        //         'service',
        //         'status',
        //         'department',
        //     ])->get();
        //     return Datatables::of($tickets)
        //         ->addColumn('action', function ($ticket) {
        //             return view('ticket::includes._index_action', compact('ticket'))->render();
        //         })
        //         ->toJson();
        // } else {
        //     return view('ticket::index');
        // }
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
            $ticket = $this->email_repository->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $ticket = $this->email_repository->find($id);
            return response()->json($ticket, 200);
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
            $ticket = $this->email_repository->findOrFail($id);
            $ticket->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Ticket has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket.index')->with($status, $message);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->email_repository->destroy($id);
            $status = 'success';
            $message = 'Ticket has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('ticket.index')->with($status, $message);
    }
}
