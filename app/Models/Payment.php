<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Salon;
use App\Models\User;

class Payment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'amount',
        'salon_id',
        'user_id'
    ];

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
