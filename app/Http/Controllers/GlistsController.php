<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Glist;

class GlistsController extends Controller
{
    public function store() {

		$attributes = $this->validateGlist();

		$attributes['user_id'] = auth()->id();

		$glist = Glist::create($attributes);

		return back();

    }
    
    public function validateGlist() {

		return request()->validate([

            'name' => ['required', 'min:3']
            
        ]);

	}
}
