<?php

namespace App\Models;

use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Method to send email verification
    public function sendEmailVerificationNotification()
    {
        // We override the default notification and will use our own
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'cin',
        'birth_date',
        'phone_number',
        'email',
        'password',
        'sexe',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->hasMany(RoleUser::class);
        // return $this->belongsToMany(Role::class)->using(RoleUser::class)->with('troupe');
        // return $this->hasManyThrough(Troupe::class,RoleUser::class,'troupe_id','id');
    }

    public function roless(){
        return $this->belongsToMany(Role::class);
    }

    public function materiels(){
        return $this->hasMany(Materiel::class,'responsable_id','id')->orderBy('created_at','DESC');
    }

    public function sentDemandeMateriels(){
        return $this->hasMany(DemandeMateriel::class,'user_id','id')->orderBy('created_at','DESC');
    }

}
