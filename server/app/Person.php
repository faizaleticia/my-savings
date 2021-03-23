<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
    ];

    /**
     * Get the user associated with the person.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
