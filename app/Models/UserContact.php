<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class UserContact extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_contacts';

    protected $fillable = [
        'user_id',
        'phone',
        'mobile',
        'address1',
        'address2',
        'address3',
        'postcode',
        'country_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}