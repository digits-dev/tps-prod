<?php
namespace App\Http\Controllers;

use App\Models\UserFolder;
use DB;
use Session;
use Request;

class CBHook extends Controller {

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	public function afterLogin() {
		DB::table('cms_users')->where('id', Session::get('admin_id'))
            ->update(['has_seen_terms_and_conditions' => true]);

        $folders = UserFolder::where('cms_users_id', Session::get('admin_id'))
            ->get(['folder_url', 'folder_name']);

        Session::put('user_folders',$folders);
	}
}
