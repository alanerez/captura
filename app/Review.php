<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    


    public function getAll(){

    	$reviews
            = DB::table('reviews')
            //->join('lead_sources', 'call_leads.lead_source_id', '=', 'lead_sources.id')
            ->select('*')
            //->groupBy('call_leads.city')
            ->get();

        return $reviews;
    }

    public function describe(){
    	$table = 'reviews';
		$columns = DB::select("SHOW COLUMNS FROM ". $table);

		return $columns;
    }
   
}

