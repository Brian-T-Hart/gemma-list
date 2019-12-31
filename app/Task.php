<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'completed', 'list_id', 'order'];

    public function glist()
	  {
		return $this->belongsTo(Glist::class);
		}
		
		public function complete($completed = true) {

			$this->update(compact('completed'));

	}
}
