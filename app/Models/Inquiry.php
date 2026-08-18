<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    const STATUSES = [
        'Received',
        'Quotation Required',
        'Quotation Sent',
        'Pending',
        'Not Responding',
        'In Progress',
        'Completed',
        'Cancelled',
    ];

    const STATUS_BADGE_CLASSES = [
        'Quotation Required' => 'badge-quotation-required',
        'Quotation Sent' => 'badge-quotation-sent',
        'Pending' => 'badge-pending',
        'Not Responding' => 'badge-not-responding',
        'In Progress' => 'badge-in-progress',
        'Completed' => 'badge-completed',
        'Cancelled' => 'badge-cancelled',
    ];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
    public function followups()
    {
        return $this->hasMany(Followup::class);
    }

    public function getStatusBadgeClassAttribute()
    {
        return self::STATUS_BADGE_CLASSES[$this->status] ?? 'badge-received';
    }
}
