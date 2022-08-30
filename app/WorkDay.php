<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
	protected $table ="work_days";
    protected $fillable = [
        'days', 'start','end'
    ];

}
