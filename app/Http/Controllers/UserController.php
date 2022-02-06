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

class UserController extends Controller
{
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

            // $link = env('MY_HOST_SERVER') . '/verification/' . base64_encode($request->email);
            // $full_name = $request->lname . ' ' . $request->fname;

            // $message = '
            //     <div>Hello ' . $full_name . '</div>
            //     <div>Thank you for signing up on Product. Please confirm your email address to complete your sign up. 
            //     It’s easy - Click the button below to access the URL directly.</div><br>
            //     <div><button style="background: blue; height: 40px;"><a href="' . $link . '" style="text-decoration: none;">Verify Email</a></button></div><br>
            //     <div>Click <span style="color: blue;"><a href="' . $link . '">here</a></span> to verifiy your account</div>
            //     <div>Once verified, you may log in and continue to create your magical event!</div><br>
            //     <div> We can’t wait to host your event!</div><br>
            //     <div>Products Team</div>
            // ';

            // $data = [
            //     "message" => $message,
            //     'link' => $link,
            //     'subject' => 'Complete your signup',

            // ];
            // Mail::to($request->email)->send(new SignUpMail($data));

            // return redirect('/pages/login')->with('success', 'A verification link has been sent to your email. Kindly verify email to continue');
        }
    }



    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $credentials = request(['email', 'password']);

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }


            return $this->createNewToken($token);
        }

        //     $validator = Validator::make($request->all(), [
        //         'email' => 'required',
        //         'password' => 'required'
        //     ]);
        //     if ($validator->fails()) {
        //         return back()->withErrors($validator);
        //     }
        //     $credentials = $request->only('email', 'password');
        //     if (!Auth::attempt($credentials, $request->remember)) {
        //         return back()->with('error', 'Invalid login details');
        //     }
        //     if (Auth::user()->role == 'user') {
        //         return redirect('/');
        //     } else 
        //     if (Auth::user()->role == 'admin') {
        //         return redirect('/');
        //     } else 
        //     if (Auth::user()->role == 'engineer') {
        //         return redirect('/');
        //     }


        //     return redirect('/users/dashboard');
        // }

        // return view('pages.login');
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
        // if ($user) {

        //     $data = [
        //         'subject' => 'Testing Application OTP',
        //         'body' => 'Your OTP is : ' . $otp
        //     ];

        //     Mail::to($request->email)->send(new sendEmail($data));

        //     return response(["status" => 200, "message" => "OTP sent successfully"]);
        // } else {
        //     return response(["status" => 401, 'message' => 'Invalid']);
        // }
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

        // if($user){
        //     auth()->login($user, true);
        //     User::where('email','=',$request->email)->update(['otp' => null]);
        //     $accessToken = auth()->user()->createToken('authToken')->accessToken;

        //     return response(["status" => 200, "message" => "Success", 'user' => auth()->user(), 'access_token' => $accessToken]);
        // }
        // else{
        //     return response(["status" => 401, 'message' => 'Invalid']);
        // }
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

            // if ($user) {
            //     auth()->login($user, true);
            //     User::where(['email' => $request->email]);

            //     return response(["status" => 200, "message" => "Success", 'user' => auth()->user()]);
            // } else {
            //     return response(["status" => 401, 'message' => 'Invalid']);
            // }


            // return response()->json([
            //     'message' => 'Password changed successfully',

            // ], 201);
        }
        //  User::create(array_merge(
        //     $validator->validated(),
        //     ['password' => bcrypt($request->password)]
        // ));

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
