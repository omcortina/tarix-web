<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'user_type',
        'client_type',
        'is_verified',
        'verified_at',
        'must_change_password',
        'company_id',
        'state',
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
        'verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Obtener las clasificaciones del usuario
     */
    public function classifications()
    {
        return $this->hasMany(Classification::class);
    }

    /**
     * Obtener las clasificaciones asignadas al clasificador
     */
    public function assignedClassifications()
    {
        return $this->hasMany(Classification::class, 'clasificador_id');
    }

    /**
     * Obtener la empresa a la que pertenece el usuario
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Determina si el usuario puede ver el precio de una clasificación.
     * - EMPRESA: siempre puede ver precios (gestiona facturación de su empresa)
     * - EXTERNO en empresa Tarix (default) o sin empresa: puede ver precios
     * - EXTERNO en otra empresa: NO puede ver precios (lo ve el usuario EMPRESA)
     */
    public function canSeePrices(): bool
    {
        if ($this->user_type === 'EMPRESA') {
            return true;
        }
        return !$this->company_id || ($this->company && $this->company->isTarix());
    }
}
