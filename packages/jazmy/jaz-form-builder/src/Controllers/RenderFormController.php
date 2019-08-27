<?php

namespace jazmy\FormBuilder\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use jazmy\FormBuilder\Helper;
use jazmy\FormBuilder\Models\Form;
use Modules\Department\Interfaces\DepartmentRepositoryInterface;
use Modules\GlobalSetting\Entities\Webhook;
use Throwable;

class RenderFormController extends Controller
{
    protected $department_repository;

    public function __construct(DepartmentRepositoryInterface $department_repository)
    {
        $this->department_repository = $department_repository->model;
        $this->middleware('public-form-access');
    }

    public function render($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        $pageTitle = "{$form->name}";

        $formUpdate = Form::where('identifier', $identifier)->update([
            'views' => $form->views + 1,
        ]);

        return view('formbuilder::render.index', compact('form', 'pageTitle'));
    }

    public function submit(Request $request, $identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        $submitted = end($form->submissions);

//        DB::beginTransaction();

        try {
            $input = $request->except('_token');
//
            $uploadedFiles = $request->allFiles();
            foreach ($uploadedFiles as $key => $file) {
                if ($file->isValid()) {
                    $input[$key] = $file->store('fb_uploads', 'public');
                }
            }

            $user_id = auth()->user()->id ?? null;

            $form->submissions()->create([
                'user_id' => $user_id,
                'content' => $input,
                'status_id' => $form->status_id,
                'department_id' => $form->department_id,
                'source_id' => $form->source_id,
            ]);

            DB::commit();

            $department = $this->department_repository->find($form->department_id);

            // Backup your default mailer
            $backup = Mail::getSwiftMailer();

            // Setup your department mailer
            $transport = new \Swift_SmtpTransport($department->outgoing_host, $department->outgoing_port, $department->outgoing_encryption);
            $transport->setUsername($department->username);
            $transport->setPassword($department->password);
            // Any other mailer configuration stuff needed...
            $department_mailer = new \Swift_Mailer($transport);
            // Set the mailer as gmail
            Mail::setSwiftMailer($department_mailer);

            $content = [];
            foreach ($input as $key=>$item) {
                array_push($content, $key." - ". $item . '<br>');
            }

            $response = Mail::raw(strip_tags(json_encode($content)), function ($message) use ($request, $department) {

                $message->getHeaders()
                    ->addTextHeader('In-Reply-To', $request->message_id);
                $message->getHeaders()
                    ->addTextHeader('References', $request->message_id);

                $message->from($department->email, $department->name);

                $message->to($department->email)->subject('New Lead Submission');

            });

            // Restore your original mailer
            Mail::setSwiftMailer($backup);

//            $webhooks = Webhook::where('form_id', $submitted[0]->form_id)->get();
//            foreach($webhooks as $webhook){
//                $headers = json_decode($webhook->headers);
//                $body = json_decode($webhook->body);
//                $heads = array();
//
//                foreach ($headers as $header){
//                    array_push($heads,[$header->header_key => $header->header_value]);
//                }
//                if(is_array($body)){
//                    foreach ($body as $el){
//                        $data[] = [$el->body_field => $request[$el->body_value]];
//                    }
//                    $req = new \GuzzleHttp\Psr7\Request($webhook->method, $webhook->url, $heads, json_encode($data));
//                }else{
//                    $body = (array)$body;
//                    $keys = array_keys($body);
//                    for($i=0; $i < count($body); $i++){
//                        $data[] = [$keys[$i] => $request[$keys[$i]]];
//                    }
//                    $req = new \GuzzleHttp\Psr7\Request($webhook->method, $webhook->url, $heads, json_encode($data));
//                }
//                $body = $req->getBody();
//                dd($body);
//            }


            return redirect()
                ->route('form.feedback', $identifier)
                ->with('success', 'Form successfully submitted.');
        } catch (Throwable $e) {
            info($e);

            DB::rollback();

            return back()->withInput()->with('error', Helper::wtf());
        }
    }

    public function feedback($identifier)
    {
        $form = Form::where('identifier', $identifier)->firstOrFail();
        $pageTitle = "Form Submitted!";

        return view('formbuilder::render.feedback', compact('form', 'pageTitle'));
    }
}
