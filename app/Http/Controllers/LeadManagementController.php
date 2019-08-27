<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Purls;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;
use Response;

class LeadManagementController extends AppBaseController
{
    /** @var  CashRegisterRepository */

    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return view('lead_management.index');
    }

    public function leadList(Request $request)
    {
        $purls = Purls::paginate(15);

        return view('lead_management.lead_list', compact('purls'));
    }

    public function create()
    {
        return view('lead_management.create');
    }

    public function store(Request $request)
    {
        $purl = Purls::create($request->except('_token', 'lead_source'));

        Flash::success('Lead saved successfully.');

        return redirect(route('lead-management.lead_list'));
    }

    public function show(Request $request)
    {
        //
    }

    public function results(Request $request){
        if($request->customerid != null){
            $purls = Purls::where('customerid', 'LIKE', '%'.$request->customerid.'%')->get();
        }else{
            $purls = Purls::where($request->select_option, 'LIKE', '%'.$request->option_value.'%')->get();
        }

        return view('lead_management.table', compact('purls'));
    }

    public function edit($id)
    {
        $purl = Purls::find($id);

        if (empty($purl)) {
            Flash::error('Lead not found');

            return redirect(route('lead-management.index'));
        }

        return view('lead_management.edit')->with('purl', $purl);
    }

    public function update($id, Request $request)
    {
        $purl = Purls::find($id);

        if (empty($purl)) {
            Flash::error('Lead not found');

            return redirect(route('lead-management.index'));
        }

        $purl = DB::table('purls')->where('id', $id)->update($request->except('_token', '_method', 'lead_source'));

        Flash::success('Lead updated successfully.');

        return redirect(route('lead-management.index'));
    }

    public function destroy($id)
    {
//        $cashRegister = $this->cashRegisterRepository->find($id);
//
//        if (empty($cashRegister)) {
//            Flash::error('Cash Register not found');
//
//            return redirect(route('cash-register.index'));
//        }
//
//        $this->cashRegisterRepository->delete($id);
//
//        Flash::success('Cash Register deleted successfully.');
//
//        return redirect(route('cash-register.index'));
    }
}
