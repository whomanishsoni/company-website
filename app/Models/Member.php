<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'father_name',
        'dob',
        'whatsapp',
        'alt_no',
        'email',
        'address',
        'city',
        'state_id',
        'pincode',
        'business',
        'blood_group',
        'inspirer',
        'cooperation_field',
    ];

    protected $dates = [
        'dob',
        'created_at',
        'updated_at',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}