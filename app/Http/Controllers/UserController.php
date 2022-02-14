<?php

namespace App\Http\Controllers;

use App\Mail\SignUpMail;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify'], ['except' => ['sign_up', 'login']]);
    }
    public function sign_up(Request $request)
    {

        if ($request->isMethod('post')) {


            $validator = Validator::make($request->all(), [
                'lname' => 'required|string|between:2,100',
                'fname' => 'required|string|between:2,100',
                'role' => 'required|string',
                'phone_number' => 'required|string|max:11',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6',

            ]);

            if (isset($request->image)) {

                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                //make a unique name
                $filename = uniqid() . '.' . $ext;
                //upload the image
                $image->move(public_path('/image'), $filename);

                $request->merge([
                    'images' => $filename,
                ]);
            }

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user
            ], 201);

             }
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }


        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function forget_password(Request $request)
    {
        $email = User::where(['email' => $request->email])->count();
        if ($email < 1) {
            return response()->json(['error' => 'Email does not exist'], 401);
        }

        $code = \random_int(100000, 999999);
        $expireTime = Carbon::now()->addMinutes(10);
        $user = User::where(['email' => $request->email])->first();

        $user->otp = $code;
        $user->otp_expire = $expireTime;

        $user->save();
        return response()->json([
            "status" => 200, "message" => "OTP sent Successfully"

        ]);
       
    }

    public function confirm_otp(Request $request)
    {

        $user  = User::where([['email', '=', $request->email], ['otp', '=', $request->otp]])->first();

        if ($user == null) {
            return response()->json(['error' => 'Invalid OTP']);
        }
        $currentTime = Carbon::now();
        if ($currentTime > $user->otp_expire) {
            return response()->json(['error' => 'OTP expired']);
        } else {
            return response()->json(["status" => 200, "message" => "Success", 'Continue to change Password',]);
        }

       
    }

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'password' => 'min:6|required_with:confirmed|same:confirmed',
                'confirmed' => 'min:6'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            $password = Hash::make($request->password);
            $updateUser =  User::where(['email' => $request->email])->update(['password' => $password]);
            $user = User::where(['email' => $request->email])->first();
            if ($updateUser) {
                return response()->json(["status" => 200, "message" => "Success", 'user' => $user]);
            }

           
        }
     

    }


    public function shop(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'shop_name' => 'required',
                'shop_address' => 'required',
                'device' => 'required',
            ]);

            if (isset($request->shop_image)) {

                $image = $request->file('shop_image');
                $ext = $image->getClientOriginalExtension();
                //make a unique name
                $filename = uniqid() . '.' . $ext;
                //upload the image
                $image->move(public_path('/shop_image'), $filename);

                $request->merge([
                    'shop_images' => $filename,
                ]);
            }

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $shop = Shop::create($request->all());

            return response()->json([
                'message' => 'Shop successfully registered',
                'shop' => $shop
            ], 201);
        }
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    //
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
