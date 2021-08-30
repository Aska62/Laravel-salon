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

    public function countFollwers() {
        $salons = $this->activeSalon();
        $followers = 0;
        foreach($salons->get() as $salon) {
            $followers += $salon->countUsers();
        }
        return $followers;
    }

    // これ不要か
    // public function countInactiveFollowers() {
    //     $salons = $this->salon()->get();
    //     $deletedSalons = $this->deletedSalon()->get();
    //     $inactives = 0;
    //     foreach ($salons as $salon ) {
    //         $inactives+= $salon->countInactiveUsers();
    //     }
    //     foreach ($deletedSalons as $dSalon) {
    //         $inactives += $dSalon->countUsers();
    //         $inactives += $dSalon->countInactiveUsers();
    //     }
    //     return $inactives;
    // }
}
