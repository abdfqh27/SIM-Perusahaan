<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }

    public function isOwner()
    {
        return $this->role && $this->role->slug === 'owner';
    }

    public function isAdminCompany()
    {
        return $this->role && $this->role->slug === 'admin-company';
    }

    public function isAdminOperasional()
    {
        return $this->role && $this->role->slug === 'admin-operasional';
    }

    // Accessor untuk URL foto profil
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return Storage::url($this->profile_photo);
        }
        
        // Default avatar jika tidak ada foto
        return asset('images/default-profil.png');
    }
}