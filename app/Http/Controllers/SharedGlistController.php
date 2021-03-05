<?php

namespace App\Http\Controllers;

use App\User;
use App\Glist;
use App\SharedGlist;
use App\Mail\SharedGlistMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SharedGlistController extends Controller {
	
	public function __construct() {

		$this->middleware('auth');

	}

	//get all glists that have been shared with user
	public function index() {

		$glists = Glist::whereHas('SharedGlists', function ($query) {

			$query->where([['user_id', auth()->id()], ['confirmed', '>', 0]]);

		})->with(['tasks' => function($query) {

			$query->latest()->get();

		}, 'SharedGlists' => function($query) {

			$query->where([['user_id', auth()->id()], ['confirmed', '>', 0]]);
			
		}])->get();

		foreach ($glists as $glist) {

			$glist['shared_with'] = true;

		}

		// return $glists;

		return view('shared', compact('glists'));


	}//index


	//get all the lists belonging to and shared with the user
	public function test() {

		$glists = Glist::where(['user_id' => auth()->id()])->with(['tasks' => function($query) {
            
            $query->latest()->get();

		}])->get();
		

		$sharedGlists = Glist::whereHas('SharedGlists', function ($query) {

			$query->where([['user_id', auth()->id()], ['confirmed', '>', 0]]);

		})->with(['tasks' => function($query) {

			$query->latest()->get();

		}])->get();

		foreach ($sharedGlists as $sharedGlist) {
			$sharedGlist['shared_with'] = true;
		}

		$glists = $glists->merge($sharedGlists);

		return $glists;

	}
	


    // public function store() {

	// }

	// public function update(SharedGlist $sharedGlist) {

	// }

	// public function archive(SharedGlist $sharedGlist) {

	// }
	
	
	public function share(Glist $glist, Request $request) {
		// Check if user exists
		$sharedWithUser = User::select('id')->where(['email' => $request->email])->first();

		// If user exists
		if ($sharedWithUser) {
			// Check if user already has access
			$sharedGlist = SharedGlist::where([
				['user_id', '=', $sharedWithUser->id],
				['glist_id', '=', $glist->id],
				['confirmed', '>', 0],
			])->first();
			
			if ($sharedGlist) {
				// Return response status 200
				return response()->json([
					'success' => true,
					'status' => 200,
					'message' => 'Oops! It looks like ' . $request->email . ' already has access to this list.',
				]);
			}// if

			$confirmCode = time();

			// Set up attributes for new sharedGlist
			$attributes['glist_id'] = $glist->id;
			$attributes['user_id'] = $sharedWithUser->id;
			$attributes['confirm_code'] = $confirmCode;

			// create sharedGlist
			$shared = SharedGlist::create($attributes);

			// Set up data to pass into email view
			$shareData['email'] = auth()->user()->email;
			$shareData['confirm'] = $confirmCode;
			$shareData = (object) $shareData;

			// Send email to sharee
			Mail::to($request->email)->send(new SharedGlistMail($shareData));

			// Return response status 200
			return response()->json([
				'success' => true,
				'status' => 201,
				'message' => 'An invitation was sent to ' . $request->email,
			]);

		} else { // No user registered with that email address

			return response()->json([
				'success' => false,
				'status' => 404,
				'message' => 'No user account found for that email address',
			]);
		}// if
	}// share

	public function confirm(Request $request) {

		$sharedGlist = SharedGlist::where([
			'user_id' => auth()->id(),
			'confirm_code' => $request->confirm
		])->get();

		if (count($sharedGlist) > 0) {
			$sharedGlist[0]->update(['confirmed' => time()]);
			return redirect('/shared');
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Invalid request'
			]);
		}

	}


	public function destroy($id) {

		$sharedGlists = SharedGlist::where([['user_id', '=', auth()->id()], ['glist_id', '=', $id]])->delete();

		return $sharedGlists;
	}
    
    // public function validate() {

	// 	return request()->validate([

    //         'name' => ['required', 'min:2', 'max:20']
            
    //     ]);

	// }

}
