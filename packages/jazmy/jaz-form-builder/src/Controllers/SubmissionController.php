<?php

namespace jazmy\FormBuilder\Controllers;

use App\Http\Controllers\Controller;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Models\Submission;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($form_id)
    {
        $user = auth()->user();

        $form = Form::where(['user_id' => $user->id, 'id' => $form_id])
            ->with(['user'])
            ->firstOrFail();

        $submissions = $form->submissions()
            ->with('user')
            ->latest()
            ->paginate(100);

        $form_headers = $form->getEntriesHeader();

        $pageTitle = "Leads for '{$form->name}'";

        return view(
            'formbuilder::submissions.index',
            compact('form', 'submissions', 'pageTitle', 'form_headers')
        );
    }

    public function show($form_id, $submission_id)
    {
        $submission = Submission::with('user', 'form')
            ->where([
                'form_id' => $form_id,
                'id' => $submission_id,
            ])
            ->firstOrFail();

        $form_headers = $submission->form->getEntriesHeader();

        $pageTitle = "View Submission";

        return view('formbuilder::submissions.show', compact('pageTitle', 'submission', 'form_headers'));
    }

    public function destroy($form_id, $submission_id)
    {
        $submission = Submission::where(['form_id' => $form_id, 'id' => $submission_id])->firstOrFail();
        $submission->delete();

        return redirect()
            ->route('form.submission.index', $form_id)
            ->with('success', 'Submission successfully deleted.');
    }
}
