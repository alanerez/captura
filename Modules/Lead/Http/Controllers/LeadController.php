<?php

namespace Modules\Lead\Http\Controllers;

use App\Http\Controllers\Controller;
use Datatables;
use DB;
use Illuminate\Http\Request;
use jazmy\FormBuilder\Models\Submission;
use Modules\Department\Entities\Department;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Modules\Lead\Entities\Lead;
use Modules\Lead\Interfaces\LeadRepositoryInterface;
use Modules\User\Interfaces\UserSettingRepositoryInterface;

class LeadController extends Controller
{
    protected $lead_repository;
    protected $global_setting_repository;
    protected $user_setting_repository;

    public function __construct(
        LeadRepositoryInterface $lead_repository,
        GlobalSettingRepositoryInterface $global_setting_repository,
        UserSettingRepositoryInterface $user_setting_repository
    ) {
        $this->lead_repository = $lead_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
        $this->user_setting_repository = $user_setting_repository->model;
        $this->middleware('permission:manage-lead', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-lead', ['only' => ['store']]);
        $this->middleware('permission:edit-lead', ['only`' => ['update']]);
        $this->middleware('permission:delete-lead', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $lead_statuses = $this->global_setting_repository->where('key', 'lead_status')->get();

            $lead_types = $this->global_setting_repository->where('key', 'lead_type')->get();

            // $form = Form::where('department_id', $request->department_id)->first();

            $leads = [];

            $leads = new Submission;

            if (isset($request->department_id)) {
                $leads = $leads->where('department_id', $request->department_id);
            }

            if (isset($request->source_id)) {
                $leads = $leads->whereIn('source_id', $request->source_id);
            }

            if (isset($request->status_id)) {
                $leads = $leads->whereIn('status_id', $request->status_id);
            }

            if (isset($request->type_id)) {
                $leads = $leads->whereIn('type_id', $request->type_id);
            }

            $leads = $leads->select([
                'id',
                'form_id',
                'content',
                'status_id',
                'type_id',
                'department_id',
                'source_id',
            ])->get();

            return Datatables::of($leads)
                ->addColumn('name', function ($lead) {
                    return @($lead->content)['name'];
                })
                ->addColumn('email_address', function ($lead) {
                    return view('lead::includes._mail_to', compact('lead'))->render();
                })
                ->addColumn('phone', function ($lead) {
                    return view('lead::includes._tel', compact('lead'))->render();
                })
                ->addColumn('company', function ($lead) {
                    return @($lead->content)['company'];
                })
                ->addColumn('status', function ($lead) use ($lead_statuses) {
                    return view('lead::includes._status_select_option', compact('lead', 'lead_statuses'))->render();
                })
                ->addColumn('source', function ($lead) {
                    return @json_decode($lead->source->value)->name;
                })
                ->addColumn('type', function ($lead) use ($lead_types) {
                    return view('lead::includes._type_select_option', compact('lead', 'lead_types'))->render();
                })
            // ->addColumn('source', function ($lead) {
            //     return @json_decode($lead->form->source->value)->name;
            // })
            // ->addColumn('department', function ($lead) {
            //     return @$lead->form->department->name;
            // })
            // ->addColumn('status', function ($lead) {
            //     return @json_decode($lead->form->status->value)->name;
            // })
            // ->addColumn('position', function ($lead) {
            //     return @($lead->content)['position'];
            // })
            // ->addColumn('address', function ($lead) {
            //     return @($lead->content)['address'];
            // })
            // ->addColumn('city', function ($lead) {
            //     return @($lead->content)['city'];
            // })
            // ->addColumn('state', function ($lead) {
            //     return @($lead->content)['state'];
            // })
            // ->addColumn('country', function ($lead) {
            //     return @($lead->content)['country'];
            // })
            // ->addColumn('zip_code', function ($lead) {
            //     return @($lead->content)['zip_code'];
            // })
            // ->addColumn('title', function ($lead) {
            //     return @($lead->content)['title'];
            // })
            // ->addColumn('description', function ($lead) {
            //     return @($lead->content)['description'];
            // })
            // ->addColumn('website', function ($lead) {
            //     return @($lead->content)['website'];
            // })
                ->addColumn('action', function ($lead) {
                    return view('lead::includes._index_action', compact('lead'))->render();
                })
                ->rawColumns(['email_address', 'phone', 'status', 'type', 'action'])
                ->toJson();
        } else {

            $fields = [
                'Name',
                'Company',
                'Email Address',
                'Phone',
                // 'Department',
                // 'Status',
                // 'Source',
                // 'Address',
                // 'Position',
                // 'City',
                // 'State',
                // 'Country',
                // 'Zip Code',
                // 'Title',
                // 'Description',
                // 'Website',
            ];

            $department = null;
            $department = Department::find($request->department_id);

            $lead_statuses = $this->global_setting_repository->where('key', 'lead_status')->get();

            $lead_sources = $this->global_setting_repository->where('key', 'lead_source')->get();

            $lead_types = $this->global_setting_repository->where('key', 'lead_type')->get();

            return view('lead::index', compact('fields', 'department', 'lead_statuses', 'lead_sources', 'lead_types'));
        }
    }

    public function indexOld(Request $request)
    {
        // $user = auth()->user();
        // $user_settings_lead_fields = $user->userSettings()->where('key', 'lead_fields')->first();

        // $all_fields = $this->global_setting_repository->where('key', 'lead_field')->pluck('value')->toArray();

        // if ($request->ajax()) {

        //     if (empty($user_settings_lead_fields)) {
        //         $fields = [
        //             // "Source",
        //             // "Type",
        //         ];

        //     } else {
        //         $fields = (array) json_decode($user_settings_lead_fields->value, true);
        //     }

        //     $leads = $this->lead_repository->select([
        //         'data',
        //         'type',
        //     ])->get();

        //     $datatable = Datatables::of($leads);

        //     foreach ($fields as $field) {

        //         // if ($field == 'Source') {
        //         //     continue;
        //         // }

        //         // if ($field == 'Type') {
        //         //     continue;
        //         // }

        //         $set_field = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '_', $field)));

        //         $datatable->addColumn($set_field, function ($lead) use ($field) {
        //             return @json_decode($lead->data)->{$field};
        //         });

        //     }
        //     return $datatable->toJson();
        // } else {

        //     if (empty($user_settings_lead_fields)) {
        //         $fields = [
        //             // "Source",
        //             // "Type",
        //         ];

        //         $in_active_fields = array_diff($all_fields, $fields);

        //     } else {
        //         $fields = (array) json_decode($user_settings_lead_fields->value, true);

        //         $in_active_fields = array_diff($all_fields, $fields);

        //         // if (!in_array('Source', $fields)) {
        //         //     $in_active_fields[] = 'Source';
        //         // }

        //         // if (!in_array('Type', $fields)) {
        //         //     $in_active_fields[] = 'Type';
        //         // }
        //     }

        //     return view('lead::index', compact('fields', 'in_active_fields'));
        // }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // $data = $request->all();
        // try {
        //     DB::beginTransaction();
        //     $lead = $this->lead_repository->create($data);
        //     DB::commit();
        //     $status = 'success';
        //     $message = 'Lead has been created.';
        // } catch (\Exception $e) {
        //     $status = 'error';
        //     $message = 'Internal Server Error. Try again later.';
        //     DB::rollBack();
        // }
        // return redirect()->route('lead.index')->with($status, $message);
    }

    public function show(Request $request, $id)
    {
        // if ($request->ajax()) {
        //     $submission = Submission::find($id);
        //     $lead = @$submission->content;
        //     return response()->json($lead, 200);
        // } else {
        //     return;
        // }
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
            $lead = Submission::findOrFail($id);
            $lead->update($data);
            DB::commit();
            $status = 'success';
            $message = 'Lead has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        } else {
            return redirect()->route('lead.index')->with($status, $message);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->lead_repository->destroy($id);
            $status = 'success';
            $message = 'Lead has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('lead.index')->with($status, $message);
    }

    public function leadFieldSetting(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        try {
            DB::beginTransaction();
            $lead_fields = $user->userSettings()->where('key', 'lead_fields')->first();
            if ($lead_fields == null) {
                $data['user_id'] = $user->id;
                $data['key'] = 'lead_fields';
                $data['value'] = json_encode($data['value']);
                $lead_fields = $this->user_setting_repository->create($data);
            } else {
                $lead_fields->update(['value' => json_encode($data['value'])]);

            }
            DB::commit();
            $status = 'success';
            $message = 'Lead column has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->back()->with($status, $message);
    }
}
