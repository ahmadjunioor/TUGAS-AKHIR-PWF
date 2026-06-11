<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
