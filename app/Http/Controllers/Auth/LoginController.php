<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

use Socialite;
use Auth;

class LoginController extends Controller
{
    /**
     * Redirect the user to the IServ authentication page.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function redirectToProvider()
    {
        return Socialite::driver('iserv')->redirect();
    }


    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */

    public function handleProviderCallback()
    {
        $iservUser = Socialite::driver('iserv')->stateless()->user();

        $user = User::where( 'email', $iservUser->email )->first();
        
        /*
         *  Checks to see if a user exists. If not we need to create the
         *  user in the database before logging them in.
         */
        
        if( $user == null )
        {
            $newUser = new User();

            $newUser->name     = $iservUser->getName();
            $newUser->vorname  = $iservUser["given_name"];
            $newUser->nachname = $iservUser["family_name"];
            $newUser->email    = $iservUser["email"];
            $newUser->username = $iservUser["preferred_username"];

            foreach($iservUser["groups"] as $key => $val) {
                if( substr($val["name"], 0, 6) == "Klasse" ) {
                    $newUser->klasse   = substr($val["name"], 7);
                    $newUser->jahrgang = substr($val["name"], 7, 2);
                    break;
                }
            }

            $newUser->save();
            $user = $newUser;
        }

        Auth::login( $user );

        return redirect()->intended('/');
    }
}
