<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;
use App\Models\Payment;

class Salon extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'salons';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'name',
        'abstract',
        'recommend',
        'benefit',
        'fee',
        'max_members',
        'owner_name',
        'owner_prof',
        'owner_email',
        'image'
    ];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function users() {
        return $this->hasMany(User::class)->whereNull('deleted_at');
    }

    public function getAllUsers() {
        return $this->users()->get();
    }

    public function deletedUser() {
        return $this->hasMany(User::class)->whereNotNull('deleted_at');
    }

    public function countUsers() {
        return $this->users()->count();
    }

    public function countInactiveUsers() {
        return $this->deletedUser()->count();
    }

    public function payment() {
        return $this->hasMany(Payment::class);
    }
}
