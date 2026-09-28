<?php

namespace App\Models\Praktikum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'praktikum_roles';

    protected $fillable = ['name'];

    public function praktikumUsers(): BelongsToMany
    {
        return $this->belongsToMany(PraktikumUser::class, 'praktikum_role_praktikum_user', 'role_id', 'praktikum_user_id');
    }
}
