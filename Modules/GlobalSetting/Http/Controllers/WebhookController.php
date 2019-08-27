<?php

namespace Modules\GlobalSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use jazmy\FormBuilder\Models\Form;
use Modules\GlobalSetting\Entities\Webhook;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;

class WebhookController extends Controller
{
    protected $global_setting_repository;
    protected $webhook_repository;

    public function __construct(GlobalSettingRepositoryInterface $global_setting_repository)
    {
        $this->global_setting_repository = $global_setting_repository->model;
    }

    public function getAllMethods()
    {
        return response()->json([
            'methods' => config('webhooks.methods'),
        ]);
    }

    public function getAllHeaders()
    {
        return response()->json([
            'headers' => config('webhooks.headers'),
        ]);
    }

    public function getAllFormats()
    {
        return response()->json([
            'formats' => config('webhooks.formats'),
        ]);
    }

    public function getAllFields(Request $request)
    {
        $data = $request->all();
        $form = Form::find($data['form_id']);
        $fields = [];
        foreach (json_decode($form->form_builder_json) as $k => $v) {
            $fields[$v->name] = $v->label;
        }
        return response()->json([
            'fields' => $fields,
        ]);
    }
    public function getWebhookData(Request $request)
    {
        $data = $request->all();
        $form = Form::find($data['form_id']);
        $webhookData = Webhook::where('form_id', $data['form_id'])->get();

        return response()->json([
            'webhookData' => $webhookData,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
         try {
             DB::beginTransaction();
             Webhook::create([
                'form_id' => $data['form_id'],
                'name' => $data['name'],
                'url' => $data['url'],
                'method' => $data['method'],
                'format' => $data['format'],
                'headers' => json_encode($data['headers']),
                'body' => json_encode($data['body']),
            ]);
             DB::commit();
         } catch (\Exception $e) {
             DB::rollBack();
         }
    }

    public function delete($fid, $id)
    {
        Webhook::where('id', $id)->delete();

        return Redirect::back();
    }
}
