<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'isbn', 'user_id',
    ];

    protected $dates = ['deleted_at'];
    /**
     * Get the user who downloaded the book.
     */

    public function user(){

        return $this->belongsTo(User::class);

    }

}
