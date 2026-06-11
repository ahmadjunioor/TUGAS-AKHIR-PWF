<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorValidation extends Model
{
    protected $guarded = [];

    public function vendorProfile(): BelongsTo
    {
        return $this->belongsTo(VendorProfile::class);
    }
}
