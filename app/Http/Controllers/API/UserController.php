<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseFormatter;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function login(Request $request)
    {
        // dd($request->all());
        $validator= Validator::make(request()->all(),[
            'email'=>'email|required',
            'password'=>'required'
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Store data gagal",422);
        }
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            return ResponseFormatter::error([
                "message"=>"Email atau password yang anda masukan salah"
            ],"Login gagal",500);
        }
    //    jika hash tidak sesuai
    $user = User::where('email',$request->email)->first();
    if(!Hash::check($request->password, $user->password, [])){
        throw new \Exception('Invalid Credentials');
    }
    // jika berhasil login
    $hasilToken = $user->createToken('authToken')->plainTextToken;
    $user->token_api = $hasilToken;
    $user->save();
    return ResponseFormatter::success([
        'access_token'=>$hasilToken,
        'token_type'=>'Bearer',
        'user'=>$user
    ]);


       
    }
    public function register(Request $request)
    {
        $validator= Validator::make(request()->all(),[
            'name'=> ['required','string','max:255'],
            'email'=>['required','string','max:255','email','unique:users'],
            'password'=>$this->passwordRules()
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Store data gagal",422);
        }

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => Hash::make($request->password),
        ]);

           
        $hasilToken = $user->createToken('authToken')->plainTextToken;
        $user =User::where('email',$request->email)->first();
        $user->token_api = $hasilToken;
        $user->save();
        return ResponseFormatter::success([
            'access_token'=>$hasilToken,
            'token_type'=>'Bearer',
            'user'=>$user
        ]);


        
    }

    public function logout(Request $request)
    {
       $token = $request->user()->currentAccessToken()->delete();
       return ResponseFormatter::success($token,'Token Revoked');

    }
}
