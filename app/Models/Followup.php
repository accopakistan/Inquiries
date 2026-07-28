<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'type_of_contact',
        'remarks',
        'followup_date',
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}
