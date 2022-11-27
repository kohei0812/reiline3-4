<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'status',
        'waiting_id',
        'place',
        'price',
        'pattern',
        'driver',
        'memo',
        'reserve_list_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function waiting()
    {
        return $this->belongsTo(Waiting::class);
    }
}
