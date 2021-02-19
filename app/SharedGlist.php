<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedGlist extends Model
{
    protected $fillable = ['glist_id', 'user_id', 'confirm_code', 'confirmed', 'archived'];

    public function glist()
	  {
		return $this->belongsTo(Glist::class);
	  }

}
