<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
    public function followups()
    {
        return $this->hasMany(Followup::class);
    }
}
