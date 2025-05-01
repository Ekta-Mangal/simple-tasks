<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Country extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'countries';

    protected $fillable = ['name', 'code', 'iso_code', 'isd_code'];
}
