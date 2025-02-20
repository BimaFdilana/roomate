<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'file_path'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}