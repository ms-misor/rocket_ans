<?php

namespace Modules\Subcription\Entities;

use App\Traits\HasCreatedUpdateBy;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Role\Entities\Module;
use Modules\Client\Entities\Client;

class PackageRecarringInvoice extends Model
{

    use HasCreatedUpdateBy;
    use HasFactory;

    protected $fillable = [ 'package_id',
                            'coustomer_id',
                            'package_duration_id',
                            'title',
                            'price',
                            'duration',
                            'payment_status',
                            'bill_start_date',
                            'invoice_date',
                            'status'
                        ];

    public function modules(){
        return $this->belongsToMany(Module::class,'package_recarring_invoice_details','package_recarring_invoice_id','module_id');
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function packageDuration(){
        return $this->belongsTo(PackageDuration::class);
    }
    public function packageRecarringInvoicePayment(){
        return $this->hasOne(PackageRecarringInvoicePayment::class,'package_recarring_invoice_id','id')->with('packagePaymentMethod');
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }


    public static function boot(){
        parent::boot();
        if(Auth::check()){
            self::creating(function($model) {
                $model->created_by = Auth::id();
            });
            self::updating(function($model) {
                $model->updated_by = Auth::id();
            });
        }

        self::created(function($model) {
            $model->invoice_no = str_pad($model->id, 6,0,STR_PAD_LEFT);
            $model->save();
        });

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
}
