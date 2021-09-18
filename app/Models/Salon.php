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

    public function payment() {
        return $this->hasMany(Payment::class);
    }

    /**
     * Find all existing users
     */
    public function getAllUsers() {
        return $this->users()->get();
    }

    /**
     * Get user id and name of all existing users
     */
    public function getAllUserIdAndName() {
        return $this->users()->select('id', 'name')->get();
    }

    /**
     * Find all deleted users
     */
    public function deletedUser() {
        return $this->hasMany(User::class)->whereNotNull('deleted_at');
    }

    /**
     * Count existing users
     */
    public function countUsers() {
        return $this->users()->count();
    }

    /**
     * Count deleted users
     */
    public function countInactiveUsers() {
        return $this->deletedUser()->count();
    }

}
