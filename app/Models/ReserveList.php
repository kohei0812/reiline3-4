<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveList extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'plan',
        'boat_num',
        'place',
        'price',
        'memo',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reserves(){
        return $this->hasMany(Reserve::class);
    }
}
