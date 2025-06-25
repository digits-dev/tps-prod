<?php

namespace App\Http\Controllers;

use App\Models\CompanyStore;
use App\Models\PrivilegeStoreAccess;
use App\Models\SalesReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use CRUDBooster;
use DB;

class AdminDashboardController extends Controller
{
    private const DINE = 1;
    private const TAKEOUT = 3;
    private const DELIVERY = 4;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $stores_data = array();
        $data['page_title'] = 'Sales';
        $stores = PrivilegeStoreAccess::getStore(CRUDBooster::myPrivilegeId())->get()->toArray();

        foreach($stores as $key => $store){
            $store_name = CompanyStore::getStore((int)$store['company_store_access'])->first();
            if(!empty($store_name)){
                array_push($stores_data, $store_name->store_name);

                $data['dine'][$key] = SalesReport::getModeofOrder($store_name->company_id,$store_name->branch_id,self::DINE)
                    ->first();

                $data['dine_qty'][$key] = SalesReport::getModeofOrderQty($store_name->company_id,$store_name->branch_id,self::DINE)
                    ->first();

                $data['takeout'][$key] = SalesReport::getModeofOrder($store_name->company_id,$store_name->branch_id,self::TAKEOUT)
                    ->first();

                $data['takeout_qty'][$key] = SalesReport::getModeofOrderQty($store_name->company_id,$store_name->branch_id,self::TAKEOUT)
                    ->first();

                $data['delivery'][$key] = SalesReport::getModeofOrder($store_name->company_id,$store_name->branch_id,self::DELIVERY)
                    ->first();

                $data['delivery_qty'][$key] = SalesReport::getModeofOrderQty($store_name->company_id,$store_name->branch_id,self::DELIVERY)
                    ->first();

                $data['total_trx'][$key] = SalesReport::getTotalTrx($store_name->company_id,$store_name->branch_id)
                    ->first();

                $data['gross_sale'][$key] = SalesReport::getGrossSale($store_name->company_id,$store_name->branch_id)
                    ->first();

                $grossStartDate = Carbon::parse($data['gross_sale'][$key]->date)->startOfMonth()->format('Y-m-d');

                $gross = SalesReport::getGrossSale($store_name->company_id,$store_name->branch_id)->whereBetween('sales_trx_date',[$grossStartDate,$data['gross_sale'][$key]->date])->get();
                $dineQty = SalesReport::getModeofOrderQty($store_name->company_id,$store_name->branch_id,self::DINE)->first();

                $sumGross = array_sum(array_column($gross->toArray(),'amount'));

                $data['adds'][$key] = $sumGross/$gross->count();
                $data['dine_ave'][$key] = $data['dine'][$key]->amount/$dineQty->count;

                $data['gross_sale_mtd'][$key] = DB::connection('tms')->table('sales_report_mtd')
                ->select(DB::raw("SUM(mtd) as amount, date_format(sales_trx_date,'%Y-%m-%d') as date"))
                ->where('company', $store_name->company_id)
                ->where('branch', $store_name->branch_id)
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->first();
            }
        }
        $data['stores'] = $stores_data;
        // dd($data);
        return view("dashboard.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
