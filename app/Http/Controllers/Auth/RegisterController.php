<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Models\Patient;

use App\Models\Role;

use Validator;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\SMConfig;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/patient/appointments';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if(!SMConfig::getByKey('user_from_login')) {
            return redirect('/');;
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if(!SMConfig::getByKey('user_from_login')) {
            return redirect('/');;
        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $messages = [
            'dni.unique' => 'El paciente con este dni ya tiene un usuario asociado.',
        ];

        $v = Validator::make($data, [
            'name' => 'required|max:60',
            'surname' => 'required',
            'address' => 'string|required',
            'primary_phone' => 'numeric|required_without:secondary_phone',
            'secondary_phone' => 'numeric|required_without:primary_phone',
            'char_phone' => 'numeric|required_with:primary_phone',
            'char_phone_2' => 'numeric|required_with:secondary_phone',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'dni' => 'required|digits_between:1,15|numeric'
        ], $messages);

        $v->sometimes('dni', 'unique:patients,dni', function ($data) {
            $patient = Patient::where('dni', $data['dni'])->first();
            return ($patient != null && $patient->user != null);
        });
        
        return $v;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if(!SMConfig::getByKey('user_from_login')) {
            return redirect('/');;
        }

        $patient = Patient::where('dni', $data['dni'])->first();
        
        if($patient == null){
            $p = Patient::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'dni' => $data['dni'],
                'address' => $data['address'],
                'primary_phone' => isset($data['primary_phone']) ? $data['char_phone'].'-'.$data['primary_phone'] : '',
                'secondary_phone' => isset($data['secondary_phone']) && $data['secondary_phone'] != '' ?  $data['char_phone_2'].'-'.$data['secondary_phone'] : '',
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            $patient = $p; 
        }

        $user = User::create([
            'name' => $patient->name,
            'email' => $data['email'],
            'api_token' => str_random(60),
            'patient_id' => $patient->id,
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::where('name','patient')->first();
        
        $user->attachRole($role);
        
        return $user;
    }
}
