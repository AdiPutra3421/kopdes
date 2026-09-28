<?php

namespace App\Models\Praktikum;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class PraktikumUser extends Model
{
    use SoftDeletes;

    protected $table = 'praktikum_users';

    protected $fillable = ['name', 'email', 'password', 'is_active', 'visits', 'first_name', 'last_name'];

    protected $hidden = ['password'];

    protected $appends = ['full_name'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'visits' => 'integer',
            'password' => 'hashed',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'praktikum_user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'praktikum_user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'praktikum_role_praktikum_user', 'praktikum_user_id', 'role_id');
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '').' '.($this->last_name ?? ''));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
