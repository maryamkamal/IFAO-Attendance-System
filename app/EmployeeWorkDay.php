<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeWorkDay extends Model
{
	protected $table ="employee_work_days";
    protected $fillable = [
        'day', 'start','end','working_type'
    ];

}
