<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lead;
use App\LeadSource;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Twiml;

class LeadController extends Controller
{

    /**
     * Twilio Client
     */
    protected $_twilioClient;

    public function __construct(Client $twilioClient)
    {
        $this->_twilioClient = $twilioClient;
    }

    public function callSummary()
    {
        $call_records = DB::table('call_records')->get();
        $call_summary = DB::table('call_summary')->get();
        $registered_numbers = DB::table('registered_numbers')->get();
        
        if(count($call_summary)!=0){
            foreach($call_summary as $el){
                DB::table('call_summary')->where('phone_number', $el->phone_number)->update([
                    'inbound' => 0,
                    'outbound_dial' => 0
                ]);
                foreach($registered_numbers as $number){
                    if($el->phone_number == $number->phone_number){
                        $total = $el->inbound + $el->outbound_dial;
                        DB::table('registered_numbers')->where('phone_number', $el->phone_number)->update([
                            'total_calls' => $total
                        ]);
                    }
                }
            }
        }

        foreach($call_records as $record){
            if($record->direction == 'inbound'){
                $check = DB::table('call_summary')->where('phone_number', $record->to)->get();

                if(count($check)==0){
                    DB::table('call_summary')->insert([
                        'phone_number' => $record->to,
                        'formatted_phone_number' => $record->toFormatted,
                        'inbound' => 1,
                        'outbound_dial' => 0
                    ]);
                }else{
                    foreach($check as $check){
                        DB::table('call_summary')->where('phone_number', $record->to)->update([
                            'inbound' => $check->inbound + 1
                        ]);
                    }
                }
            }else if($record->direction == 'outbound-dial'){
                $check = DB::table('call_summary')->where('phone_number', $record->from)->get();
                if(count($check)==0){
                    DB::table('call_summary')->insert([
                        'phone_number' => $record->from,
                        'formatted_phone_number' => $record->fromFormatted,
                        'inbound' => 1,
                        'outbound_dial' => 0
                    ]);
                }else{
                    foreach($check as $check){
                        DB::table('call_summary')->where('phone_number', $record->from)->update([
                            'outbound_dial' => $check->outbound_dial + 1
                        ]);
                    }
                }
            }        
        }
    }

    public function saveAllCalls()
    {
        $twilioClient = $this->_twilioClient;
        
        $calls = $twilioClient->calls
                ->read(array());
        
        $numbers = $twilioClient->incomingPhoneNumbers->read(array());
        
        foreach($numbers as $number){
            $check = DB::table('registered_numbers')->where('phone_number', $number->phoneNumber)->get();

            if(count($check) == 0){
                DB::table('registered_numbers')->insert([
                    'phone_number' => $number->phoneNumber,
                    'formatted_phone_number' => $number->friendlyName,
                ]);
            }else{
                DB::table('registered_numbers')->where('phone_number', $number->phoneNumber)->update([
                    'sid' => $number->sid
                ]);
            }
        }

        foreach ($calls as $record) {
           $check = DB::table('call_records')->where('sid', $record->sid)->get();

           if(count($check) == 0){
               DB::table('call_records')->insert([
                'accountSid' => $record->accountSid,
                'annotation' => $record->annotation,
                'answeredBy' => $record->answeredBy,
                'apiVersion' => $record->apiVersion,
                'callerName' => $record->callerName,
                'dateCreated' => $record->dateCreated,
                'dateUpdated' => $record->dateUpdated,
                'direction' => $record->direction,
                'duration' => $record->duration,
                'endTime' => $record->endTime,
                'forwardedFrom' => $record->forwardedFrom,
                'from' => $record->from,
                'fromFormatted' => $record->fromFormatted,
                'groupSid' => $record->groupSid,
                'parentCallSid' => $record->parentCallSid,
                'phoneNumberSid' => $record->phoneNumberSid,
                'price' => $record->price,
                'priceUnit' => $record->priceUnit,
                'sid' => $record->sid,
                'startTime' => $record->startTime,
                'status' => $record->status,
                'to' => $record->to,
                'toFormatted' => $record->toFormatted,
                'uri' => $record->uri
               ]);
           } else{}
        }
    }

    public function getNumber($id){
        $twilioClient = $this->_twilioClient;
        $check = DB::table('registered_numbers')->where('sid', $id)->first();

        // $calls = $twilioClient->calls->read(array('phoneNumberSid' => $id));
        $calls = $twilioClient->calls->read(['phoneNumberSid' => $id]);
        dd($calls);
        return view('leads.detail', compact('calls', 'check'));
    }
    /**
     * Display a listing of leads
     * @param Request $request
     * @return Response with all found leads
     */
    public function dashboard(Request $request)
    {
        $this->saveAllCalls();
        $this->callSummary();

        $total = 0;
        $calls = DB::table('call_summary')->get();
        foreach($calls as $call){
            $total += $call->inbound + $call->outbound_dial; 
        }
        $context = [
            'leadSources' => LeadSource::all(),
            'appSid' => $this->_appSid(),
            'call_summary' => DB::table('call_summary')->get(),
            'numbers' => DB::table('registered_numbers')->get(),
            'call_records' => DB::table('call_records')->orderBy('startTime', 'desc')->get(),
            'total_calls' => $total 
        ];
        
        return response()->view('leads.index', $context);
    }

    /**
     * Endpoint which store a new lead with its lead source and forward the call
     *
     * @param  Request $request Input data
     * @return Response Twiml to redirect call to the forwarding number
     */
    public function store(Request $request)
    {
        $leadSource = LeadSource::where(['number' => $request->input('To')])
            ->first();
        $lead = new Lead();
        $lead->leadSource()->associate($leadSource->id);

        $lead->city = $this->_normalizeName($request->input('FromCity'));
        $lead->state = $this->_normalizeName($request->input('FromState'));

        $lead->caller_number = $request->input('From');
        $lead->caller_name = $request->input('CallerName');
        $lead->call_sid = $request->input('CallSid');

        $lead->save();

        $forwardMessage = new Twiml();
        $forwardMessage->dial($leadSource->forwarding_number);

        return response($forwardMessage, 201)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Display all lead sources as JSON, grouped by lead source
     *
     * @param  Request $request
     * @return Response
     */
    public function summaryByLeadSource()
    {
        return response()->json(Lead::byLeadSource());
    }

    /**
     * Display all lead sources as JSON, grouped by city
     *
     * @param  Request $request
     * @return Response
     */
    public function summaryByCity()
    {
        return response()->json(Lead::byCity());
    }

    /**
     * The Twilio TwiML App SID to use
     * @return string
     */
    private function _appSid()
    {
        $appSid = config('app.twilio')['TWILIO_APP_SID'];

        if (isset($appSid)) {
            return $appSid;
        }

        return $this->_findOrCreateCallTrackingApp();
    }

    private function _findOrCreateCallTrackingApp()
    {
        $existingApp = $this->_twilioClient->applications->read(
            array(
                "friendlyName" => 'Call tracking app'
            )
        );
        if (count($existingApp)) {
            return $existingApp[0]->sid;
        }

        $newApp = $this->_twilioClient->applications
            ->create('Call tracking app');

        return $newApp->sid;
    }

    private function _normalizeName($toNormalize)
    {
        if (is_null($toNormalize)) {
            return '';
        } else {
            return $toNormalize;
        }
    }
}
