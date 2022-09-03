<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function SocialSignup($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
//        if ( copy($file, $newfile) ) {
//            echo "Copy success!";
//        }else{
//            echo "Copy failed.";
//        }
//        return response()->json($user);
        $userExists = User::where('externalId', $user->id)->where('externalAuth', $provider)->exists();
        if ($userExists){
            $user=User::where('externalId', $user->id)->first();

            return response()->json([
                'token'=>$user->createToken('web')->plainTextToken,
                'user'=>$user
            ],200);
        }else{
            $nombreArchivo = time().".jpg";
            $newfile = 'imagenes/'.$nombreArchivo;
            copy($user->avatar, $newfile);
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->externalId = $user->id;
            $newUser->externalAuth = $provider;
            $newUser->avatar = $nombreArchivo;
            $newUser->fechaLimite=date('Y-m-d', strtotime(now(). ' + 360 days'));
            $newUser->save();
            $token=$newUser->createToken('web')->plainTextToken;
            return response()->json([
                'token'=>$token,
                'user'=>User::find($newUser->id)
            ],200);
        }

    }
}
