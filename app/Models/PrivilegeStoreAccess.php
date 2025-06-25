<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegeStoreAccess extends Model
{
    use HasFactory;
    protected $table = 'privilege_store_accesses';

    public function scopeGetStore($query, $privilege){
        return $query->where('cms_privileges_id', $privilege)->where('status','ACTIVE');
    }
}
