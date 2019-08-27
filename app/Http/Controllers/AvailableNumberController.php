<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class AvailableNumberController extends Controller
{

    /**
     * Twilio Client
     */
    protected $_twilioClient;

    public function __construct(Client $twilioClient)
    {
        $this->_twilioClient = $twilioClient;
    }

    /**
     * Display numbers available for purchase. Fetched from the API
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $areaCode = $request->input('areaCode');

        if($areaCode==800 || $areaCode==833 || $areaCode==844 || $areaCode==855 || $areaCode==866 || $areaCode==877 || $areaCode==888){
            $numbers = $this->_twilioClient->availablePhoneNumbers('US')
            ->tollFree->stream(
                [
                    'areaCode' => $areaCode
                ]
            );
        }else{
            $numbers = $this->_twilioClient->availablePhoneNumbers('US')
            ->local->stream(
                [
                    'areaCode' => $areaCode
                ]
            );
        }

        return response()->view(
            'available_numbers.index',
            [
                'numbers' => $numbers,
                'areaCode' => $areaCode
            ]
        );
    }
}
