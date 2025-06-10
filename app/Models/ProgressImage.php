<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress_entry_id',
        'image_path',
        'note',
    ];

    public function entry()
    {
        return $this->belongsTo(ProgressEntry::class, 'progress_entry_id');
    }
}
