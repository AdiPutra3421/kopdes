<?php

namespace App\Models\Praktikum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'praktikum_posts';

    protected $fillable = ['praktikum_user_id', 'title', 'body'];

    public function praktikumUser(): BelongsTo
    {
        return $this->belongsTo(PraktikumUser::class, 'praktikum_user_id');
    }
}
