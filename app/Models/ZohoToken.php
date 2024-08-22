<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZohoToken extends Model
{
    use HasFactory;

    protected $table = 'zoho_tokens';

    protected $fillable = [
        'access_token',
        'refresh_token'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
