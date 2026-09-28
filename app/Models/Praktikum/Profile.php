<?php

namespace App\Models\Praktikum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'praktikum_profiles';

    protected $fillable = ['praktikum_user_id', 'phone', 'address'];

    public function praktikumUser(): BelongsTo
    {
        return $this->belongsTo(PraktikumUser::class, 'praktikum_user_id');
    }
}
