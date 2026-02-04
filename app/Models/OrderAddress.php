<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $guarded = [];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getFormattedAddressAttribute()
    {
        $address = $this->address;

        if (!$address) {
            return null;
        }

        $lines = [];

        // العنوان الأساسي
        $lines[] = $address->street;

        // تفاصيل السكن
        $details = [];
        if ($address->building)  $details[] = 'Building ' . $address->building;
        if ($address->floor)     $details[] = 'Floor ' . $address->floor;
        if ($address->apartment) $details[] = 'Apartment ' . $address->apartment;

        if (!empty($details)) {
            $lines[] = implode(' - ', $details);
        }

        // المنطقة
        if ($address->area) {
            $lines[] = implode(', ', array_filter([
                $address->area->name,
                optional($address->area->parent)->name,
                optional($address->area->parent->parent)->name,
            ]));
        }

        // Postal code
        if ($address->postal_code) {
            $lines[] = 'Postal Code: ' . $address->postal_code;
        }

        // Phone
        if ($address->phone) {
            $lines[] = 'Phone: ' . $address->phone;
        }

        return $lines;
    }

}
