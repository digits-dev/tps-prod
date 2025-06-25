<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyStore extends Model
{
    use HasFactory;
    protected $table = 'company_stores';

    public function scopeGetStore($query, $store_id){
        return $query->where('id',$store_id);
    }
}
