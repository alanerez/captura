<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCashRegisterRequest;
use App\Http\Requests\UpdateCashRegisterRequest;
use App\Models\CashRegister;
use App\Models\Goal;
use App\Repositories\CashRegisterRepository;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;
use Response;

class CashRegisterController extends AppBaseController
{
    /** @var  CashRegisterRepository */
    private $cashRegisterRepository;

    public function __construct(CashRegisterRepository $cashRegisterRepo)
    {
        $this->cashRegisterRepository = $cashRegisterRepo;
    }

    /**
     * Display the dashboard of the CashRegister.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function dashboard(Request $request){
        $id = date('m');
        $goal = DB::table('goal')->latest('created_at')->first();
        $totalDebt = $this->totalDebt();
        $totalTransaction = $this->totalTransaction();
        $monthlyGross = $this->monthlyGross(date('m'));
        $totalProfit = $this->totalProfit();
        $m_pro_total = ($monthlyGross['totalDebt']/ $goal->monthly_income)* (100);
        $m_transactions = ($monthlyGross['transactions']/ $goal->transactions) * (100);
        $m_gross_goal = ($monthlyGross['income']/ $goal->monthly_debt) * (100);
        $monthlyData = $this->monthlyData();

        return view('cash_registers.dashboard', compact('totalDebt', 'totalTransaction', 'monthlyGross', 'totalProfit', 'id', 'm_pro_total', 'm_transactions', 'm_gross_goal'));
    }

    public function monthDashboard($month, $year, Request $request){
        $totalDebt = $this->totalDebt();
        $totalTransaction = $this->totalTransaction();
        $monthlyGross = $this->monthlyGross(date('m'));
        $totalProfit = $this->totalProfit();
        $goal = DB::table('goal')->latest('created_at')->first();
        $m_pro_total = ($monthlyGross['totalDebt']/ $goal->monthly_income)* (100);
        $m_transactions = ($monthlyGross['transactions']/ $goal->transactions) * (100);
        $m_gross_goal = ($monthlyGross['income']/ $goal->monthly_debt) * (100);
        $monthlies = DB::table('monthly_transactions')->get();
        $monthlyData = $this->monthlyData();

        return view('cash_registers.month_dashboard', compact('totalDebt', 'totalTransaction', 'monthlyGross', 'totalProfit', 'month', 'year', 'm_pro_total', 'm_transactions', 'm_gross_goal', 'monthlies'));
    }

    public function monthlyData(){
        $monthly = DB::table('cash_registers')->get();
        $cash = CashRegister::get();

            for($i = 1; $i <=12; $i++){
                switch($i){
                    case "1":
                        $month = "01";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "2":
                        $month = "02";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "3":
                        $month = "03";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "4":
                        $month = "04";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "5":
                        $month = "05";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "6":
                        $month = "06";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "7":
                        $month = "07";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "8":
                        $month = "08";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "9":
                        $month = "09";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "10":
                        $month = "10";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "11":
                        $month = "11";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    case "12":
                        $month = "12";
                        $debt_onboarded = 0;
                        $sales = 0;
                        $sales_lifetime =0;
                        $legal =0;
                        $admin =0;
                        $notary =0;
                        $transactions =0;
                        foreach ($cash as $el){
                            $checkMonth = date("m");
                            $year = Carbon::now()->year;
                            $getMonth = explode('-', $el->name);
                            if($getMonth[1] == $i && $getMonth[0] == $year){
                                $debt_onboarded += $el->cash;
                                $sales += $el->cash * .16;
                                $sales_lifetime += $el->cash * 0.16 / 22;
                                $transactions += $el->transactions;
                                $legal += $el->transactions * 100;
                                $admin += $el->transactions * 55;
                                $notary += $el->transactions * 100;

                                $sales_comm = $sales * .01;
                                $admin_comm = $sales_comm * .20;
                                $monthlyPayables = $legal + $admin + $sales_comm + $admin_comm + $notary;

                                $check = DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->get();
                                if(count($check) == 0){
                                    DB::table('monthly_transactions')->insert([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                                else{
                                    DB::table('monthly_transactions')->where('month', $getMonth[0].'-'.$getMonth[1])->update([
                                        'month' => $getMonth[0].'-'.$getMonth[1],
                                        'transactions' => $transactions,
                                        'legal' => $legal,
                                        'admin' => $admin,
                                        'sales_comm' => $sales_comm,
                                        'admin_comm' => $admin_comm,
                                        'notary' => $notary,
                                        'sales' => $sales,
                                        'debt_onboarded' => $debt_onboarded,
                                        'sales_lifetime' => $sales_lifetime,
                                        'updated_at' => Carbon::now()
                                    ]);
                                }
                            }
                        }
                        break;
                    default:
                        echo Carbon::now();
                }
            }
    }

    /**
     * Display the goals of the CashRegister.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function goals(Request $request){
        $goals = DB::table('goal')->get();
        $total = $this->monthlyGross(date('m'));

        return view('cash_registers.goals', compact('total', 'goals'));
    }

    public function editGoal($id){
        $goal = DB::table('goal')->where('id', $id)->first();

        return view('cash_registers.edit_goal', compact('goal'));
    }

    public function updateGoal(Request $request){
        $goal = DB::table('goal')->where('id', $request['id'])->update([
            'monthly_debt' => $request['monthly_debt'],
            'transactions' => $request['transactions'],
            'monthly_income' => $request['monthly_income'],
        ]);

        Flash::success('Goal saved successfully.');

        return redirect()->route('cash-register.goals');

    }

    public function deleteGoal($id){
        DB::table('goal')->where('id', $id)->delete();

        Flash::success('Goal deleted successfully.');

        return redirect()->back();
    }

    public function createGoal()
    {
        return view('cash_registers.add_goal');
    }

    public function addGoal(Request $request){
        $data = $request->all();

        DB::table('goal')->insert([
            'monthly_income' => $data['monthly_income'],
            'monthly_debt' => $data['monthly_debt'],
            'transactions' => $data['transactions'],
//            'growth' => $data['growth'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('cash-register.goals');
    }

    /**
     * Display a listing of the CashRegister.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $m = date('m');
        $y = date('Y');
        $cashRegisters = CashRegister::where('name', 'LIKE', '%'.$y.'-'.$m.'%')->get();

        return view('cash_registers.index')
            ->with('cashRegisters', $cashRegisters);
    }

    /**
     * Show the form for creating a new CashRegister.
     *
     * @return Response
     */
    public function create()
    {
        return view('cash_registers.create');
    }

    /**
     * Store a newly created CashRegister in storage.
     *
     * @param CreateCashRegisterRequest $request
     *
     * @return Response
     */
    public function store(CreateCashRegisterRequest $request)
    {
        $input = $request->all();

        $cashRegister = $this->cashRegisterRepository->create($input);

        Flash::success('Cash Register saved successfully.');

        return redirect(route('cash-register.index'));
    }

    /**
     * Display the specified CashRegister.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cashRegister = $this->cashRegisterRepository->find($id);
        $grossIncome = $this->grossIncome($id);
        $legal = $this->legalPayment($id);
        $admin = $this->adminPayment($id);
        $notary = $this->notaryPayment($id);
        $salesComm = $this->salesCommission($id);
        $managementComm = $this->managementCommission($id);
        $bankFees = $this->bankFees($id);

        if (empty($cashRegister)) {
            Flash::error('Cash Register not found');

            return redirect(route('cash-register.index'));
        }

        return view('cash_registers.show', compact('grossIncome', 'legal', 'admin', 'notary', 'salesComm', 'managementComm', 'bankFees'))->with('cashRegister', $cashRegister);
    }

    /**
     * Show the form for editing the specified CashRegister.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cashRegister = $this->cashRegisterRepository->find($id);

        if (empty($cashRegister)) {
            Flash::error('Cash Register not found');

            return redirect(route('cash-register.index'));
        }

        return view('cash_registers.edit')->with('cashRegister', $cashRegister);
    }

    /**
     * Update the specified CashRegister in storage.
     *
     * @param int $id
     * @param UpdateCashRegisterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCashRegisterRequest $request)
    {
        $cashRegister = $this->cashRegisterRepository->find($id);

        if (empty($cashRegister)) {
            Flash::error('Cash Register not found');

            return redirect(route('cash-register.index'));
        }

        $cashRegister = $this->cashRegisterRepository->update($request->all(), $id);

        Flash::success('Cash Register updated successfully.');

        return redirect(route('cash-register.index'));
    }

    /**
     * Remove the specified CashRegister from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cashRegister = $this->cashRegisterRepository->find($id);

        if (empty($cashRegister)) {
            Flash::error('Cash Register not found');

            return redirect(route('cash-register.index'));
        }

        $this->cashRegisterRepository->delete($id);

        Flash::success('Cash Register deleted successfully.');

        return redirect(route('cash-register.index'));
    }


    public function grossIncome($id) {
        $cash = CashRegister::where('id', $id)->first();
        $grossIncome = ($cash->cash * 0.16) / 22;

        return $grossIncome;
    }

    public function legalPayment($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = 100 * $cash->transactions;

        return $payment;
    }

    public function adminPayment($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = 55 * $cash->transactions;

        return $payment;
    }

    public function notaryPayment($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = 100 * $cash->transactions;

        return $payment;
    }

    public function salesCommission($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = ($cash->cash * 0.01);

        return $payment;
    }

    public function managementCommission($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = $this->salesCommission($id) * .20 ;

        return $payment;
    }

    public function bankFees($id) {
        $cash = CashRegister::where('id', $id)->first();
        $payment = 15 * $cash->transactions;

        return $payment;
    }

    public function totalDebt(){
        $cash = CashRegister::get();
        $total = 0;
        foreach ($cash as $el){
            $total += $el->cash;
        }

        return $total;
    }

    public function totalTransaction(){
        $cash = CashRegister::get();
        $total = 0;
        foreach ($cash as $el){
            $total += $el->transactions;
        }

        return $total;
    }

    public static function ytdGrowth(){

        try{
            $cash = CashRegister::get();
            $goal = DB::table('goal')->latest('created_at')->first();
            $total = 0;
            $transactions = 0;
            foreach ($cash as $el){
                $total += $el->cash;
                $transactions += $el->transactions;
            }

            $ytd = (($total - $goal->monthly_debt) / $goal->monthly_debt);
            $growth  = ($ytd / $goal->growth) * 100;
            $income_goal = (($total * 0.16)/ ($goal->monthly_income));
            $deals_goal = (($transactions) / ($goal->transactions)) * 100;
            $debt_goal = ($total / $goal->monthly_debt) * 100;
        } catch(\Throwable $e) {
            $ytd = 0;
            $income_goal = 0;
            $deals_goal = 0;
            $debt_goal = 0;
            $growth = 0;
        }

        return compact('ytd', 'income_goal', 'deals_goal', 'debt_goal', 'growth');
    }

    public static function monthlyGross($month){
        $cash = CashRegister::get();

        switch($month){
            case "1":
                $month = "01";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "2":
                $month = "02";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "3":
                $month = "03";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "4":
                $month = "04";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "5":
                $month = "05";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "6":
                $month = "06";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "7":
                $month = "07";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "8":
                $month = "08";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "9":
                $month = "09";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "10":
                $month = "10";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "11":
                $month = "11";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            case "12":
                $month = "12";
                $totalDebt = 0;
                $income = 0;
                $totalInc =0;
                $legal =0;
                $admin =0;
                $notary =0;
                $transactions =0;
                $monthlyPayables =0;
                $salesComm =0;
                $managementComm =0;
                $profit = 0;
                $mprofit =0;
                foreach ($cash as $el){
                    $checkMonth = date("m");
                    $year = Carbon::now()->year;
                    $getMonth = explode('-', $el->name);
                    if($getMonth[1] == $month && $getMonth[0] == $year){
                        $totalDebt += $el->cash;
                        $income += $el->cash * .16;
                        $totalInc += $el->cash * 0.16 / 22;
                        $transactions += $el->transactions;
                        $legal += $el->transactions * 100;
                        $admin += $el->transactions * 55;
                        $notary += $el->transactions * 100;

                        $salesComm = $income * .01;
                        $managementComm = $salesComm * .20;
                        $monthlyPayables = $legal + $admin + $salesComm + $managementComm + $notary;
                    }
                }
                $profit = $income - $monthlyPayables;
                $mprofit = $totalInc - $monthlyPayables;
                return compact('income', 'monthlyPayables', 'totalDebt', 'transactions', 'legal', 'admin',
                    'notary', 'salesComm', 'managementComm', 'totalInc', 'mprofit', 'profit');
                break;
            default:
                echo Carbon::now();
        }
    }

    public function totalProfit(){
        $cash = CashRegister::get();
        $totalDebt = 0;
        $income = 0;
        $legal =0;
        $admin =0;
        $notary =0;
        $salesComm =0;
        $managementComm =0;
        $bankFees =0;
        $payables =0;
        $transactions =0;
        $totalInc =0;

        foreach ($cash as $el){
            $checkMonth = date("m");
            $year = Carbon::now()->year;
            $getMonth = explode('-', $el->name);
            $totalDebt += $el->cash;
            $transactions += $el->transactions;
            $income += $el->cash * 0.16;
            $totalInc += $el->cash * 0.16 / 22;
            $legal += $el->transactions * 100;
            $admin += $el->transactions * 55;
            $notary += $el->transactions * 100;
            $salesComm += $el->cash * .01;
            $managementComm += $salesComm * .20;
            $bankFees += $el->transactions * 15;
            $payables = $legal + $admin + $notary + $salesComm + $managementComm;
            $profit = $income - $payables;
        }
        return compact('profit', 'income', 'payables', 'totalDebt', 'transactions', 'legal', 'admin', 'bankFees', 'notary', 'salesComm', 'managementComm');
    }
}
