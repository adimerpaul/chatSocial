<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    public function index(Request $request){
        return User::where('id','!=',1)->where('id','!=',$request->user()->id)->get();
    }
    public function show($id)
    {
        $chats= Chat::whereRaw("(userEnviado_id=1 AND userRecibido_id=$id)OR(userEnviado_id=$id AND userRecibido_id=1)")->get();
        return $chats;
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas'],
            ]);
        }
        return response()->json([
            'token'=>$user->createToken('web')->plainTextToken,
            'user'=>$user
        ],200);
    }
    public function register(Request $request){
        $request->validate([
            'email'=>'required|unique:users|email',
            'name'=>'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        $user=new User();
        $user->name= ( $request->name);
        $user->email=$request->email;
        $user->password=Hash::make( $request->password);
        $user->fechaLimite=date('Y-m-d', strtotime(now(). ' + 360 days'));
        $user->fechaConexion=now();
        $user->save();
        $token=$user->createToken('web')->plainTextToken;
        return response()->json([
            'token'=>$token,
            'user'=>User::find($user->id)
        ],200);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
            'tipo' => 'required',
            'fechaLimite' => 'required',
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->tipo=$request->tipo;
        $user->password= Hash::make($request->password) ;
        $user->fechaLimite=$request->fechaLimite;
        $user->save();
    }
    public function update(Request $request,User $user){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'tipo' => 'required',
            'fechaLimite' => 'required',
        ]);
        $user->update($request->all());
        return $user;
    }

    public function updatePassword(Request $request,User $user){
        $this->validate($request, [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        $user->update([
            'password'=>Hash::make($request->password)
        ]);
        return $user;
    }
    public function destroy(User $user){
        $user->delete();
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['res'=>'salido exitosamente'],200);
    }
    public function me(Request $request){
        $user=User::where('id',$request->user()->id)->firstOrFail();
        return $user;
    }
}
