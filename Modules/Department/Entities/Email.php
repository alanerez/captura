<?php

namespace Modules\Department\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\UuidForKey;

class Email extends Model
{
    use UuidForKey, SoftDeletes;

    public $fillable = [
        'message_id',
        'message_no',
        'subject',
        'references',
        'date',
        'from',
        'to',
        'cc',
        'bcc',
        'text_body',
        'html_body',
        'reply_to',
        'in_reply_to',
        'sender',
        'priority',
        'uid',
        'msglist',
        'flags',
        'attachments',
        'department_id',
        'assigned_user_id',
        'reply_user_id',
        'status_id',
        'service_id',
        'priority_id',
        'tags',
        'type',
    ];
}
