<?php

namespace Modules\Department\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use File;
use Illuminate\Http\Request;
use Mail;
use Modules\Department\Interfaces\DepartmentRepositoryInterface;
use Modules\Department\Interfaces\EmailRepositoryInterface;
use Modules\GlobalSetting\Interfaces\GlobalSettingRepositoryInterface;
use Uuid;
use Modules\Department\Entities\EmailReply;
use Webklex\IMAP\Client;

class EmailController extends Controller
{
    protected $department_repository;
    protected $global_setting_repository;
    protected $email_repository;

    public function __construct(
        DepartmentRepositoryInterface $department_repository,
        GlobalSettingRepositoryInterface $global_setting_repository,
        EmailRepositoryInterface $email_repository
    ) {
        $this->department_repository = $department_repository->model;
        $this->global_setting_repository = $global_setting_repository->model;
        $this->email_repository = $email_repository->model;
        // $this->middleware('permission:manage-email', ['only' => ['index', 'show']]);
        // $this->middleware('permission:add-email', ['only' => ['store']]);
        // $this->middleware('permission:edit-email', ['only`' => ['update']]);
        // $this->middleware('permission:delete-email', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $department = $this->department_repository->find($request->department_id);

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


            $response = Mail::raw(strip_tags($request->content), function ($message) use ($request, $department) {

                $message->getHeaders()
                    ->addTextHeader('In-Reply-To', $request->message_id);
                $message->getHeaders()
                    ->addTextHeader('References', $request->message_id);

                $message->from($department->email, $department->name);

                $message->to($request->to)->subject($request->subject);

            });

            // Restore your original mailer
            Mail::setSwiftMailer($backup);

            $reply = new EmailReply();
            $reply->message_id = $request->message_id;
            $reply->department_id = $request->department_id;
            $reply->subject = $request->subject;
            $reply->text_body = strip_tags($request->content);
            $reply->html_body = $request->content;
            $reply->from = $department->email;
            $reply->to = $request->to;
            $reply->save();

            $status = 'success';
            $message = 'Email Sent';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = $e->getMessage();
            DB::rollBack();
        }

        return redirect()->back();
    }

    public function show(Request $request, $id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $department = $this->department_repository->findOrFail($id);

        try {
            DB::beginTransaction();

            $oClient = new Client([
                'host' => $department->incoming_host,
                'port' => (int) $department->incoming_port,
                'encryption' => $department->incoming_encryption,
                'validate_cert' => $department->incoming_validate_cert == 1 ? true : false,
                'username' => $department->username,
                'password' => $department->password,
                'protocol' => $department->incoming_protocol,
            ]);

            $oClient->connect();

            $aFolder = $oClient->getFolders();

            foreach ($aFolder as $oFolder) {

                $aMessage = $oFolder->query()->unseen()->get();

                foreach ($aMessage as $oMessage) {

                    $existing_email = $this->email_repository->where('message_id', $oMessage->getMessageId())->first();

                    if ($existing_email) {
                        continue;
                    }

                    $email = [];

                    $email['department_id'] = $department->id;

                    $email['message_id'] = $oMessage->getMessageId();

                    $message_checker = $this->email_repository->where('message_id', $email['message_id'])->first();

                    if ($message_checker != null) {
                        continue;
                    }

                    $email['subject'] = $oMessage->getSubject();
                    $email['references'] = $oMessage->getReferences();
                    $email['date'] = $oMessage->getDate();

                    $email['from'] = json_encode($oMessage->getFrom());
                    $email['to'] = json_encode($oMessage->getTo());
                    $email['cc'] = json_encode($oMessage->getCc());
                    $email['bcc'] = json_encode($oMessage->getBcc());

                    $email['reply_to'] = json_encode($oMessage->getReplyTo());
                    $email['sender'] = json_encode($oMessage->getSender());
                    $email['priority'] = json_encode($oMessage->getPriority());

                    $email['html_body'] = $oMessage->getHTMLBody();
                    $email['text_body'] = $oMessage->getTextBody();

                    $email['in_reply_to'] = $oMessage->getInReplyTo();

                    $email['flags'] = $oMessage->getFlags();

                    $email['uid'] = $oMessage->getUid();
                    $email['msglist'] = $oMessage->getMsglist();
                    $email['message_no'] = $oMessage->getMessageNo();

                    if ($oMessage->hasAttachments()) {

                        $aAttachments = $oMessage->getAttachments();

                        $email['attachments'] = array();

                        $aAttachments->each(function ($oAttachment) use (&$email, $oMessage) {

                            $message_bytes = $oMessage->getStructure()->bytes;
                            $limit_b = 4000000;
                            $ext = $oAttachment->getExtension();
                            $type_exts = ['jpg', 'png', 'pdf'];

                            if (in_array($ext, $type_exts)) {
                                if ($limit_b >= $message_bytes) {
                                    $uuid = Uuid::generate();
                                    $nameAttachment = $uuid . '.' . $ext;

                                    $oAttachment->save(storage_path('emails_attachment'), $nameAttachment);

                                    $email['attachments'][] = [
                                        'file_path' => 'emails_attachment/' . $nameAttachment,
                                        'mine_type' => $oAttachment->getMimeType(),
                                        'extension' => $ext,
                                        'name' => $oAttachment->getName(),
                                        'type' => $oAttachment->getType(),
                                        'size' => $this->bytesToHuman(File::size(storage_path('emails_attachment/' . $nameAttachment))),
                                    ];
                                }
                            }
                        });

                        $email['attachments'] = json_encode($email['attachments']);
                    }

                    $this->email_repository->create($email);

                }
            }

            $status = 'success';
            $message = 'Connected';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = $e->getMessage();
            DB::rollBack();
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        } else {
            return redirect()->back()->with($status, $message);
        }

    }

    public function destroy($id)
    {
        //
    }

    private static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
