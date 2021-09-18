<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Salon;

class Owner extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'owners';
    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'owner_name',
        'profile',
        'email',
    ];

    public function salon() {
        return $this->hasMany(Salon::class);
    }

    public function activeSalon() {
        return $this->hasMany(Salon::class)->whereNull('deleted_at');
    }

    public function deletedSalon() {
        return $this->hasMany(Salon::class)->whereNotNull('deleted_at');
    }

    /**
     * Get total capacity of all the salon the owner has
     *
     * @return int $capacity
     */
    public function getCapacity() {
        $salons = $this->activeSalon();
        $capacity = 0;
        foreach($salons->get() as $salon) {
            $capacity += $salon->max_members;
        }
        return $capacity;
    }

    /**
     * Count sum of active users of existing salons
     *
     * @return int $followers
     */
    public function countFollwers() {
        $salons = $this->activeSalon();
        $followers = 0;
        foreach($salons->get() as $salon) {
            $followers += $salon->countUsers();
        }
        return $followers;
    }
}
