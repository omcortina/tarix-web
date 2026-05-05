<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'nit',
        'contact_name',
        'contact_email',
        'contact_phone',
        'address',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Get all users belonging to this company
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    /**
     * Get all classifications from users in this company
     */
    public function classifications()
    {
        return Classification::whereIn('user_id', $this->users()->pluck('id'));
    }
    
    /**
     * Check if this is the default Tarix company
     */
    public function isTarix()
    {
        return $this->name === 'Tarix';
    }
    
    /**
     * Get active companies ordered by name
     */
    public static function active()
    {
        return self::where('is_active', true)->orderBy('name');
    }
}
