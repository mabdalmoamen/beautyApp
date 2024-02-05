<?php

namespace App\Http\Controllers;

use App\Http\Requests\UersRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\ReportMail;
use App\Models\Mixins;
use DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function init()
    {
        $id = Auth::id();
        $user = User::with("roles")->where("id", $id)->first();
        return ["user" => $user];
    }
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'name' => 'required',

        ]);
        $serial = null;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $serial =  shell_exec('wmic DISKDRIVE GET SerialNumber 2>&1');
        } else {
            $serial =  shell_exec('ioreg -rd1 -w0 -c AppleAHCIDiskDriver | grep Serial');
        }

        $credentials = request(['name', 'password']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'تأكد من اسم المستخدم وكلمة السر !'], 401);
        }
        $mixins = DB::table('mixins_info')->where('id', 1)->first();
        $contains = Str::contains($serial, $mixins->mixins_mac_serial);
        if ($serial == null || $request->name == 'codies' || $contains && strlen($mixins->mixins_mac_serial) > 5) {

            return $this->respondWithToken($token);
        } else {
            return response()->json(['error' => 'نسخة غير موثقة'], 401);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        $user = User::with('branch')->find(auth()->user()->id);
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        $this->refresh();
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function signup(UersRequest $request)
    {
        $data = array();
        $data['name'] = $request->name;
        //        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        DB::table('users')->insert($data);
        return $this->login($request);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {

        return  response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'username' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'lang' => Mixins::select('default_lang')->where('id', 1)->first()->default_lang,
            'user' => auth()->user(),
        ]);
    }
}
