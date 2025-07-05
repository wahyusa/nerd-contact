<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Zodiac extends Model
{
    protected $fillable = ['name', 'symbol', 'element', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Auto-detect zodiac from birth date
    public static function detectFromDate(Carbon $birthDate): ?self
    {
        $month = $birthDate->month;
        $day = $birthDate->day;
        
        return self::whereRaw('
            (MONTH(start_date) < MONTH(end_date) AND 
             ((:month = MONTH(start_date) AND :day >= DAY(start_date)) OR
              (:month > MONTH(start_date) AND :month < MONTH(end_date)) OR
              (:month = MONTH(end_date) AND :day <= DAY(end_date)))) OR
            (MONTH(start_date) > MONTH(end_date) AND 
             ((:month = MONTH(start_date) AND :day >= DAY(start_date)) OR
              (:month > MONTH(start_date)) OR
              (:month < MONTH(end_date)) OR
              (:month = MONTH(end_date) AND :day <= DAY(end_date))))
        ', ['month' => $month, 'day' => $day])
        ->first();
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
