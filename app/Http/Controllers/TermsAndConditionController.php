<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TermsAndConditionController extends Controller
{
    public function checkTermsAccepted(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::table("cms_users")->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            if (!$user->has_seen_terms_and_conditions) {
                return response()->json(['accepted' => false]);
            }
        }
        return response()->json(['accepted' => true]);
    }
}
