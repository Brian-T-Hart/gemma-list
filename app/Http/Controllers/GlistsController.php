<?php

namespace App\Http\Controllers;

use App\User;
use App\Glist;
use App\SharedGlist;
use App\Mail\SharedGlistMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
	
	public function share(Glist $glist, Request $request) {
		// Check if user exists
		$sharedWithUser = User::select('id')->where(['email' => $request->email])->get();

		// If user exists
		if (count($sharedWithUser) > 0) {
			$confirmCode = time();

			// Set up attributes for new sharedGlist
			$attributes['glist_id'] = $glist->id;
			$attributes['user_id'] = $sharedWithUser[0]->id;
			$attributes['confirm_code'] = $confirmCode;

			// create sharedGlist
			$shared = SharedGlist::create($attributes);

			// Set up data to pass into email view
			$shareData['email'] = $request->email;
			$shareData['title'] = $glist->name;
			$shareData['confirm'] = $confirmCode;
			$shareData = (object) $shareData;

			// Send email to sharee
			Mail::to($request->email)->send(new SharedGlistMail($shareData));

			// Return response status 200
			return response()->json([
				'success' => true,
				'status' => 201,
			]);

		} else { // No user registered with that email address

			return response()->json([
				'success' => false,
				'status' => 404,
				'message' => 'No user account found for that email address',
			]);

		}

	}

	public function confirm(Request $request) {

		// $confirm_code = $request->confirm;

		$sharedGlist = SharedGlist::where([
			'user_id' => auth()->id(),
			'confirm_code' => $request->confirm
		])->get();

		if (count($sharedGlist) > 0) {
			$sharedGlist[0]->update(['confirmed' => time()]);
			return $sharedGlist;
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Invalid request'
			]);
		}

	}
    
    public function validateGlist() {

		return request()->validate([

            'name' => ['required', 'min:2', 'max:20']
            
        ]);

	}

}
