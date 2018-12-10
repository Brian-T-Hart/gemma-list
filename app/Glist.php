<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Glist extends Model
{
	protected $fillable = ['name', 'description', 'archived', 'user_id'];

	  public function tasks()
	  {
		return $this->hasMany(Task::class);
	  }
}