<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VendorProfile extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function validation(): HasOne
    {
        return $this->hasOne(VendorValidation::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public static function cityMatches(?string $requestCity, ?string $vendorCityCode): bool
    {
        if (!$requestCity || !$vendorCityCode) {
            return false;
        }

        if (strcasecmp($requestCity, 'Indonesia') === 0) {
            return true;
        }

        $city = \Laravolt\Indonesia\Models\City::where('code', $vendorCityCode)->first();
        if (!$city) {
            return false;
        }

        $cityName = strtolower($city->name);
        $searchCity = strtolower($requestCity);

        return str_contains($cityName, $searchCity) || str_contains($searchCity, $cityName);
    }

    public function getProvinceNameAttribute()
    {
        if (!$this->province) return '-';
        $name = \Laravolt\Indonesia\Models\Province::where('code', $this->province)->first()?->name;
        return $name ? ucwords(strtolower($name)) : $this->province;
    }

    public function getCityNameAttribute()
    {
        if (!$this->city) return '-';
        $name = \Laravolt\Indonesia\Models\City::where('code', $this->city)->first()?->name;
        return $name ? ucwords(strtolower($name)) : $this->city;
    }

    public function getDistrictNameAttribute()
    {
        if (!$this->district) return '-';
        $name = \Laravolt\Indonesia\Models\District::where('code', $this->district)->first()?->name;
        return $name ? ucwords(strtolower($name)) : $this->district;
    }

    public function getSubDistrictNameAttribute()
    {
        if (!$this->sub_district) return '-';
        $name = \Laravolt\Indonesia\Models\Village::where('code', $this->sub_district)->first()?->name;
        return $name ? ucwords(strtolower($name)) : $this->sub_district;
    }
}
