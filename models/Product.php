<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Model name for billings collection
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Allow fillable for model entries
     *
     * @var array
     */
    protected $guarded = [''];
}
