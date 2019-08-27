<?php

namespace jazmy\FormBuilder\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use jazmy\FormBuilder\Events\Form\FormCreated;
use jazmy\FormBuilder\Events\Form\FormDeleted;
use jazmy\FormBuilder\Events\Form\FormUpdated;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Requests\SaveFormRequest;
use Throwable;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = "Forms";
        $forms = Form::getForUser(auth()->user());

        return view('formbuilder::forms.index', compact('pageTitle', 'forms'));
    }

    public function create()
    {
        $pageTitle = "Create New Form";
        $saveURL = route('form.store');

        $countries = \Countries::select(['name AS label', 'name AS value'])->get()->toArray();

        array_unshift($countries, [
            'label' => '',
            'value' => '',
        ]);

        foreach ($countries as $key => $value) {
            $countries[$key]['selected'] = false;
        }

        return view('formbuilder::forms.create', compact('pageTitle', 'saveURL', 'countries'));
    }

    public function store(SaveFormRequest $request)
    {
        $user = $request->user();
        $input = $request->merge(['user_id' => $user->id])->except('_token');

        DB::beginTransaction();

        $input['identifier'] = $user->id . '-' . Helper::randomString(20);
        $created = Form::create($input);

        try {
            event(new FormCreated($created));

            DB::commit();

            return response()
                ->json([
                    'success' => true,
                    'details' => 'Form successfully created!',
                    'dest' => route('form.index'),
                ]);
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return response()->json(['success' => false, 'details' => 'Failed to create the form.']);
        }
    }

    public function show($id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])
            ->with('user')
            ->withCount('submissions')
            ->firstOrFail();

        $pageTitle = "Preview Form";

        return view('formbuilder::forms.show', compact('pageTitle', 'form'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();

        $pageTitle = 'Edit Form';
        $saveURL = route('form.update', $form);

        $countries = \Countries::select(['name AS label', 'name AS value'])->get()->toArray();

        array_unshift($countries, [
            'label' => '',
            'value' => '',
        ]);

        foreach ($countries as $key => $value) {
            $countries[$key]['selected'] = false;
        }

        return view('formbuilder::forms.edit', compact('form', 'pageTitle', 'saveURL', 'countries'));
    }

    public function update(SaveFormRequest $request, $id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();

        $input = $request->except('_token');

        if ($form->update($input)) {
            event(new FormUpdated($form));

            return response()
                ->json([
                    'success' => true,
                    'details' => 'Form successfully updated!',
                    'dest' => route('form.index'),
                ]);
        } else {
            response()->json(['success' => false, 'details' => 'Failed to update the form.']);
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $form = Form::where(['user_id' => $user->id, 'id' => $id])->firstOrFail();
        $form->delete();

        event(new FormDeleted($form));

        return back()->with('success', "'{$form->name}' deleted.");
    }
}
