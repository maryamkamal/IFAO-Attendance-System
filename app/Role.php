<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name'
    ];
   public function authority($authority,$page)
  {
	 $authorized = RoleAuthority::select($authority)->where('role_id','=',$this->id)->where('page',$page)->first();
	  return $authorized->$authority;
  }
}
