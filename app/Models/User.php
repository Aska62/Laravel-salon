<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Salon;
use App\Models\Payment;
use Laravel\Cashier\Billable;
use Stripe\Stripe;

class User extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Billable;

    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'id',
        'name',
        'email',
        'salon_id',
        'stripe_id'
    ];
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    // public function getSalon()
    // {
    //     return $this->salon()->first();
    // }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentOfTheMonth()
    {
        return $this->payment()
            ->where('created_at', '>=', strtotime(date('Ym').'01 00:00:00'))
            ->first();
    }
}
