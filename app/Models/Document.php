<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'file_path',
        'status',
    ];

    /**
     * Obtenir l'utilisateur propriétaire du document.
     */

    public function user(): BelongsTo
    {   
        return $this->belongsTo(User::class);
    }
}
