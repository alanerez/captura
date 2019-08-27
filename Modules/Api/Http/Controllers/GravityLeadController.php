<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Modules\Lead\Interfaces\LeadRepositoryInterface;

class GravityLeadController extends Controller {
    protected $lead_repository;
    protected $global_setting_repository;

    public function __construct(LeadRepositoryInterface $lead_repository, GlobalSettingRepositoryInterface $global_setting_repository) {
        $this->lead_repository = $lead_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
    }

    public function index(Request $request) {
        //
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $data['type'] = 'gravity';
            $lead = $this->lead_repository->create($data);

            //Create Lead Source If Not Exist
            $lead_source = $this->global_setting_repository
                ->where('key', 'lead_source')
                ->where('value->name', $data['source'])
                ->first();

            if (empty($lead_source)) {
                $lead_source = $this->global_setting_repository->create([
                    'key' => 'lead_source',
                    'value' => @json_encode(array(
                        'name' => $data['source'],
                    )),
                ]);
            }

            $lead->update(['lead_source_id' => $lead_source->id]);

            foreach (json_decode($data['data']) as $key => $value) {
                $this->global_setting_repository->firstOrCreate(['value' => $key, 'key' => 'lead_field']);
            }
            DB::commit();
            $status = 200;
            $message = 'Lead has been created.';
        } catch (\Exception $e) {
            $status = $e->getCode();
            $message = $e->getMessage();
            DB::rollBack();
        }
        return response()->json([
            'message' => $message,
        ], $status);
    }

    public function show(Request $request, $id) {
        //
    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
