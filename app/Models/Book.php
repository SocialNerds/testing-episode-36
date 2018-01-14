<?php

namespace App\Models;

use App\Models\Helpers\Uuids;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $incrementing = false;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id', 'title', 'description', 'isbn',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'pivot'
    ];

}
