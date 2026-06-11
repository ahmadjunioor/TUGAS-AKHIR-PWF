<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'booking_details' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function acceptedQuotation()
    {
        return $this->quotations()->where('status', 'accepted')->first();
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'open' => 'Menunggu Penawaran',
            'bidding_closed' => 'Penawaran Ditutup',
            'assigned' => 'Vendor Dipilih',
            'in_progress' => 'Sedang Dikerjakan',
            'awaiting_confirmation' => 'Menunggu Konfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'disputed' => 'Sengketa',
            default => ucfirst($this->status),
        };
    }
}
