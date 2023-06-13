<?php

namespace Modules\Subcription\Entities;

use App\Traits\HasCreatedUpdateBy;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageRecarringInvoicePayment extends Model
{

    use HasCreatedUpdateBy;
    use HasFactory,SoftDeletes;

    protected $fillable = ['package_payment_method_id','total_amount','received_date'];
    public function packagePaymentMethod(){
        return $this->belongsTo(PackagePaymentMethod::class);
     }
    protected static function boot(){
        parent::boot();
        if(Auth::check()){
            self::creating(function($model) {
                $model->created_by = Auth::id();
            });

            self::updating(function($model) {
                $model->updated_by = Auth::id();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

}
