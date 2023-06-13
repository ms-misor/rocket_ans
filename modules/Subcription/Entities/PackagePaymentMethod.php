<?php

namespace Modules\Subcription\Entities;

use App\Traits\HasCreatedUpdateBy;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackagePaymentMethod extends Model
{

    use HasCreatedUpdateBy;
    use HasFactory;

    protected $fillable = ['title','status'];

}