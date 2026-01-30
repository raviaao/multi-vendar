<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',

        'payment_method',
        'payment_status',
        'order_status',

        // 🔥 Razorpay fields
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',

        'subtotal',
        'shipping',
        'tax',
        'total',
        'notes',
    ];

    // ================= Relations =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ================= Accessors =================

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAddressFullAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ' - ' . $this->zip_code;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];

        return '<span class="badge bg-' . ($badges[$this->order_status] ?? 'secondary') . '">' .
            ucfirst($this->order_status) . '</span>';
    }
}
