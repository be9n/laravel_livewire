<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime',
        'time' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeFilterByTypeWhen($query, $type, $value)
    {
        return $query->when($value, function ($query, $value) use ($type) {
            return $query->where($type, '=', $value);
        });
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'SCHEDULED' => 'primary',
            'CLOSED' => 'success',
        ];
        return $badges[$this->status];
    }

    public function getGenderBadgeAttribute()
    {
        $badges = [
            'male' => 'primary',
            'female' => 'danger',
        ];
        return $badges[$this->gender];
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->dateTimeFormat('date');
    }

    public function getTimeAttribute($value)
    {
        return Carbon::parse($value)->dateTimeFormat('time');
    }
}
