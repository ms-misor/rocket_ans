<?php

namespace Modules\Subcription\Entities;

use App\Traits\HasCreatedUpdateBy;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Role\Entities\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{

    use HasCreatedUpdateBy;
    use HasFactory;

    protected $fillable = ['title','price','duration','offer','offer_price','offer_discount','offer_start_date','offer_duration','offer_status','status'];


    public function modules(){
        return $this->belongsToMany(Module::class,'package_modules','package_id','module_id');
    }
}
