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

        dd($iservUser);

        $user = User::where( 'email', $iservUser->email )->first();
        
        /*
         *  Checks to see if a user exists. If not we need to create the
         *  user in the database before logging them in.
         */        
        if( $user == null )
        {
            $user = new User();
            $user->email = $iservUser["email"];
        }

        //$user->name     = $iservUser->getName();
        $user->vorname  = $iservUser["given_name"];
        $user->nachname = $iservUser["family_name"];
         
        foreach($iservUser["groups"] as $key => $val) 
        {
            if( substr($val["name"], 0, 6) == "Klasse" ) 
            {
                $user->klasse   = substr($val["name"], 7);
                //$user->jahrgang = substr($val["name"], 7, 2);
                break;
            }
        }

        $user->save();

        Auth::login( $user );

        return redirect('sportwahlen');
    }
}
