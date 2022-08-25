<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/job';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'required|numeric',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone_number' => $data['phone_number'],
            'team' => $data['team'],
            'code_name' => $data['code_name'],
        ]);
    }
	
	public function showRegistrationForm()
	{
		//return redirect('login');
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register');
	}

    public function showMember(Request $request)
	{
		//return redirect('login');
        
        $items = null;
        $items = $this->queryData($request);

        return view('auth.member', [
            'users' => $items,
        ]);
	}

    private function queryData($request)
    {       
        $items = User::where('deleted_at','=', null) ->get();

		if ($request->get('name') && $request->get('email')) {
            $items = User::where('email','LIKE','%'. $request->get('email').'%') 
            ->where('name','LIKE','%'. $request->get('name').'%')
            ->get();          
        }else if ($request->get('name')){
            $items = User::where('name','LIKE','%'. $request->get('name').'%')  ->get();          
        }else if ($request->get('email'))
        {
            $items = User::where('email','LIKE','%'. $request->get('email').'%')  ->get();          
        }else{
            $items = User::get();
        }

		if ($request->get('team')) {
            $items = $items->where('team', $request->get('team'));
        }

        return $items;
    }

	public function register(Request $request)
	{
       
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        return redirect('/member?name=' . $request->name)->with('success', 'เพิ่มข้อมูลผู้ใช้งานเรียบร้อย');
	}

    public function edit(Request $request)
	{
        $items = null;
		if ($request->get('id')){
            $items = User::where('id', $request->get('id')) ->first();
            return view('auth.edit',[
                'items' => $items,
            ]);
        }else{
           
            $items = $this->queryData($request);
    
            return view('auth.member', [
                'users' => $items,
            ]);
        }
	}

    public function store(Request $request) 
	{
		if ($request->get('id') != ""){
			//update
			$user = User::where('id', $request->get('id'))->first();	
			if(!empty($user)) {
				$user->name = $request->name;
				$user->email = $request->email;
				$user->phone_number = $request->phone_number;
				$user->team = $request->team;
				$user->code_name = $request->code_name;
                if ($request->password){
                    $user->password = bcrypt($request->password);
                }
				if(!empty(User::where('email','=', $request->email)-> where('id', '<>', $request->get('id')) ->first())){
					return redirect('/member/edit?id=' .  $request->id)->with('success', 'อีเมล์ซ้ำ');
				}
                if ($request->status == "0"){
                    $user->deleted_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
                }else{
                    $user->deleted_at = null;
                }
				$user->save();
				return redirect('/member?name=' . $request->name)->with('success', 'แก้ไขข้อมูลผู้ใช้งานเรียบร้อย');
			}else{
				return redirect('/member/edit?id=' . $request->id);
			}		
		}
		
	}
}
