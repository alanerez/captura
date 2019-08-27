<?php

namespace App\Http\Controllers;

use Artisan;
use App\Http\Requests;
use App\Review;
use App\Department;
use DB;
use Illuminate\Http\Request;
use Validator,Redirect,Response;

class ReviewController extends Controller
{

    public function __construct()
    {
       
    }

    /**
     * Display a listing of leads
     * @param Request $request
     * @return Response with all found leads
     */


     public function index()
    {        
        $departments=new Department();
        $review              = new Review;
        
        $context = [
            'departments'   => $departments->getAll(),
            'reviews'       => $review->getAll()
            // 'appSid' => $this->_appSid()
        ];

        return response()->view('reviews.index', $context);
    }

    public function generate_csrf_token()
    {        
        return csrf_token();
    }

    public function describe_table(){
        // $review     = new Review;
        // $table      = $review->describe();

        // return Response::json($table);


        $reviews = DB::table('reviews')->count();
        return Response::json($reviews);
    }




    public function migrate(){
        Artisan::call('migrate');
    }


    
    public function submit_review(Request $request)    
    {   
        try{
            $review                 = new Review;
            $review->brandid        = $request->brandid;
            $review->depid          = $request->depid;
            $review->name           = $request->name;
            $review->email          = $request->email;
            $review->review_text    = $request->review_text;
            $review->rating         = $request->rating;
            $result                 = $review->save();

            return Response::json($result);
        }catch(Exception $e){
             return Response::json($e);
        }
    } 
    
}
