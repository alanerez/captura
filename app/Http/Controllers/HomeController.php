<?php

namespace App\Http\Controllers;

use jazmy\FormBuilder\Models\Submission;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Modules\Lead\Interfaces\LeadRepositoryInterface;
use Modules\User\Interfaces\UserSettingRepositoryInterface;

class HomeController extends Controller
{
    protected $lead_repository;
    protected $global_setting_repository;
    protected $user_setting_repository;

    public function __construct(
        LeadRepositoryInterface $lead_repository,
        GlobalSettingRepositoryInterface $global_setting_repository,
        UserSettingRepositoryInterface $user_setting_repository
    ) {
        $this->middleware('auth');
        $this->lead_repository = $lead_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
        $this->user_setting_repository = $user_setting_repository->model;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $q_leads = Submission::all();
        $leads = [];

        foreach ($q_leads as $key => $value) {
            $leads[] = [
                'id' => $value->id,
                'title' => @$value->content['name'],
                'start' => $value->created_at,
                'className' => 'bg-success',
                'url' => route('form.submission.show', [$value->form, $value->id]),
            ];
        }

        $lead_count = $q_leads->count();

        $lead_source_count = $this->global_setting_repository->where('key', 'lead_source')->count();

        return view('modules.home.dashboard', compact('leads', 'lead_count', 'lead_source_count'));
    }
}
