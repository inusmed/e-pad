<?php namespace Modules\Akun\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('akun::login');
    }

    /**
     * store login to check authorization
     *
     * @param string username
     * @param string password
     * 
     * @return bool
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required',
            'captcha'   => 'required|captcha|max:6'
        ],['captcha.captcha'=>'Invalid captcha code.']);

        if( !$validator->fails() )
        {
            #| Filter request login with username or email..
            $field = filter_var(request($this->username()), FILTER_VALIDATE_EMAIL)
                ? $this->username()
                : 'username';

            $remember_me = request('remember') ? true : false;
            
            # Unauthorized..
            if (!auth()->attempt( [$field => request('email'), 'password' => request('password')], $remember_me) ) {
                return response()->json([
                    'status'   => false,
                    'message'  => flash(trans('auth.failed'))->error()
                ], 401);
            }

            # Authorization
            $user = auth()->user();

            $redirect = '/';
            
            # redirect to activation
            if ( !$user->verify ) $redirect = 'auth/activation';

            $data['user'] = [
                'fullname'  => $user->name,
                'token'     => $user->createToken('epad access for '.$user->name)->accessToken
            ];

            # block if user is not enabled
            if (!$user->enabled)
            {
                $redirect = 'logout';

                flash(trans('auth.disabled'))->error();
                return redirect('login');
            }
            
            return response()->json([
                'status'    => true,
                'message'   => 'Access Granted',
                'data'      => $data,
                'path'      => $redirect
            ], 200);
        }

        return response()->json([
            'status'   => false,
            'message'  => $validator->getMessageBag()->toArray()
        ], 422);
    }

    public function destroy()
    {
        $this->logout();
        return redirect('login');
    }

    public function logout()
    {
        auth()->logout();

        // Session destroy is required if stored in database
        if (env('SESSION_DRIVER') == 'database') {
            $request = app('Illuminate\Http\Request');
            $request->session()->getHandler()->destroy($request->session()->getId());
        }
    }
}
