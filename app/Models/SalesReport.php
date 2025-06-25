<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SalesReport extends Model
{
    use HasFactory;
    protected $connection = 'tms';
    protected $table = 'sales_reports';

    public function scopeGetModeofOrder($query, $company_id, $branch_id, $mode){
        return $query->select(DB::raw("SUM(gross_amount) as amount, date_format(sales_trx_date,'%Y-%m-%d') as date"))
            ->where('company', $company_id)
            ->where('branch', $branch_id)
            ->where('source', $mode)
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }

    public function scopeGetModeofOrderQty($query, $company_id, $branch_id, $mode){
        return $query->select(DB::raw("COUNT(distinct receipt_number) as count, date_format(sales_trx_date,'%Y-%m-%d') as date"))
            ->where('company', $company_id)
            ->where('branch', $branch_id)
            ->where('source', $mode)
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }

    public function scopeGetGrossSale($query, $company_id, $branch_id){
        return $query->select(DB::raw("SUM(gross_amount) as amount, date_format(sales_trx_date,'%Y-%m-%d') as date"))
            ->where('company', $company_id)
            ->where('branch', $branch_id)
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }

    public function scopeGetTotalTrx($query, $company_id, $branch_id){
        return $query->select(DB::raw("COUNT(distinct receipt_number) as count, date_format(sales_trx_date,'%Y-%m-%d') as date"))
            ->where('company', $company_id)
            ->where('branch', $branch_id)
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }

    public function scopeGetGrossSum($query, $company_id, $branch_id){
        return $query->select(DB::raw("SUM(gross_amount) as amount"))
            ->where('company', $company_id)
            ->where('branch', $branch_id);
    }

}
