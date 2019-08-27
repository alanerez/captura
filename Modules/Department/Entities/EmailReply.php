<?php

namespace Modules\Department\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\UuidForKey;

class EmailReply extends Model
{
    use UuidForKey;

    public $fillable = [
        'message_id',
        'department_id',
        'subject',
        'references',
        'from',
        'to',
        'text_body',
        'html_body',
        'attachments',
    ];

    public function __toString()
    {
        return $this->attachments;
    }
}
