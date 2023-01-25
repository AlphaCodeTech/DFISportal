<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function classes()
    {
        return $this->hasMany(Clazz::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->staff_ID = "DFIS/SEC/STAFF/" . date('Y') . '/' . rand(10000, 99999);
        });
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Clazz::class, 'user_id', 'class_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function detail()
    {
        return $this->hasOne(UserInformation::class, 'user_id');
    }
}
