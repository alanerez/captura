<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function getAll(){

    	$departments
            = DB::table('departments')
            //->join('lead_sources', 'call_leads.lead_source_id', '=', 'lead_sources.id')
            ->select('*')
            //->groupBy('call_leads.city')
            ->get();

        return $departments;
    }
}
