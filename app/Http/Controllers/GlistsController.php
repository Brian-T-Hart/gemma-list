<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Glist;

class GlistsController extends Controller {
	
	public function __construct() {

		$this->middleware('auth');

    }

    public function store() {

		$attributes = $this->validateGlist();

		$attributes['user_id'] = auth()->id();

		$glist = Glist::create($attributes);

		return back();

	}

	public function update(Glist $glist) {

		$this->authorize('update', $glist);

		$attributes = $this->validateGlist();

		Glist::where('id', $glist->id)->update($attributes);

		return back();

	}

	public function archive(Glist $glist) {

		$this->authorize('update', $glist);

		$archived = $glist->archived == 1 ? 0 : 1;

		Glist::where('id', $glist->id)->update(['archived'=>$archived]);

		return back();

	}
	
	public function destroy(Glist $glist) {

		$this->authorize('delete', $glist);

		$glist->delete();

		return $glist;

	}

	public function order(Request $request) {

        $ids = json_decode($request->ids);

        foreach ($ids as $key => $value){

            $attributes['order'] = $key;

            $updatedGlist = Glist::where(['id' => $value])->update($attributes);

          }

          return response()->json([
            'success' => true,
            'status' => 200
        ]);
    }
    
    public function validateGlist() {

		return request()->validate([

            'name' => ['required', 'min:2', 'max:20']
            
        ]);

	}

}
