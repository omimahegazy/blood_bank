<?php

namespace App\Http\Controllers\Api;

use App\Blood_type;
use App\Client;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//Illuminate\Database\Eloquent\Relations\BelongsTo









use vendor\project\StatusTest;

class AuthController extends Controller


{
    public function register(Requests $request)
    {

        $rules= [
            'name' =>'required',
            'city_id'       => 'required',
            'phone'                 => 'required|unique:clients'|numeric,
            'last_donation'        => 'required|date_format:Y-m-d',
            'date_of_birth'  => 'required|date_format:Y-m-d',
            'blood_type_id' => 'required|exists:blood_types,id',
            'password' => 'required|mim:3|max:20|confirmed',
            'email' => 'required|unique:clients',
            'is_active' => 'required'
        ];
        $validation = validator::make($request->all(),$rules);

        if ($validation->fails()) {
            return responseJson(status0, $validation->errors()->first(), $validation->errors());

        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = str_random(60);
        $client->save();


        $client->governorates()->attach($client->id);
        $bloodType = Blood_type::where('name', $request->blood_type)->first();
        $client->blood_types()->attach($bloodType->id);



        return responseJson(1, 'client added successfully', [
            'api_token' => $client->api_token,
            'client' => $client
        ]);

    }



    public function login(Requests $request)
    {


        $data = $request->Json()->all();
        $rules = ['phone' => 'required|unique:clients',
            'password' => 'required|mim:3|max:20confirmed'

        ];
        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return responseJson(Status0, $validator->errors()->first(), $validator->errors());
        }


        $client = Client::where('phone', $request->phone)->first();
        if ($client && $client->is_active==1)
        {
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'login', [
                    'api_token' => $client->api_token,
                    client => $client
                ]);
            } else {
                return responseJson(0, 'the login data is incorrect');
            }
        }


        else
        {
            return responseJson(0 , 'The login data is incorrect');
        }

    }


    public function updateProfile(Request $request){
        $validation = validator()->make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients')->ignore($request->user()->id)],
            'phone' => ['required', 'numeric', 'min:11', Rule::unique('clients')->ignore($request->user()->id)],
            'password' => 'confirmed'
        ]);
        if($validation->fails()){
            $errorData = $validation->errors();
            return responseJson(0, $errorData->first(), $errorData);
        }
        $loginUser = $request->user();
        $loginUser->update($request->all());
        if($loginUser->has('password')){
            $loginUser->password = bcrypt($request->password);
        }
        $loginUser->save();
        if($request->has('governorate_id'))
        {
            $loginUser->governorates()->detach($request->governorate_id);
            $loginUser->cities()->attach($request->governorat_id);
        }
        if($request->has('blood_type'))
        {
            $bloodType = Blood_type::where('name', $request->blood_type)->first();
            $loginUser->bloodTypes()->detach($bloodType->id);
            $loginUser->bloodTypes()->attach($bloodType->id);
        }

        $data = [
            'client' => $request->user()->fresh()->load('city.governorate','bloodType')
        ];
        return responseJson(1,'mess:update',$data);
    }


    public function getprofile($id)
    {
        $client_details = Client::find($id);
        if($client_details){
            return responseJson(1 , 'client details' , $client_details);
        }
        return responseJson(0 , 'Not Found This Client');
    }


public function Password(Request $request){

    $data = $request->Json()->all;
    $rules=[
     'phone'=>'required',
        'pin_code'=>'required',
        'password'=>'required'

    ];


    $validator = validator::make($data, $rules);

    if ($validator->fails()) {
        return responseJson(Status0, $validator->errors()->first(), $validator->errors());
    }
    $user = Client::where('phone', $request->phone)->first()->where('pin_code',$request->pin_code)->where('pin_code','!=',0);



    if ($user)
    {
        $user->password=bcrypt($request->password);

        $user->pin_code = null;
        if ($user->save())
        {
            return responseJson(1,'password change successfully');
        }else{
            return responseJson(0,'An error occurred,please try again');
        }
    }else{
        return responseJson(0,'this code is invalid');
    }
}
public function resetPassword(request $request)
{
$data=$request->Json()->all();
    $rules=[
        'phone'=>'required',

    ];

    $validator = validator::make($data, $rules);

    if ($validator->fails()) {
        return responseJson(Status0, $validator->errors()->first(), $validator->errors());
    }



    $user = Client::where('phone', $request->phone)->first();


    if($user)
    {


        $code = rand(1111,9999);
        $updateUser = $user->update(['pin_code' => $code]);
        if ($updateUser)
        {

//send email

            Mail::to($user->email)
       ->bcc("maihagazy1510@gmail.com")
                ->send(new ResetPassword($code));

            return responseJson(1,'please check your phone',
                [
                    'pin_code_for_test' => $code,


                ]);
         }else{
            return responseJson(0,'An error occurred,please try again');
        }
    }else{
        return responseJson(0,'No account associated with this number');
    }
}

    public function notificationsSettings(Request $request)
    {
        $data=$request->Json()->all();
       $rules = [
            'governorates' => 'required|exists:governorates,id',
            'blood_types' => 'exists:blood_types,id',
        ];
        $validator = validator::make($data),$rules);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        if ($request->has('governorates'))
        {
            $request->client()->governorates()->sync($request->governorates);
        }
        if ($request->has('blood_types'))
        {
            $request->client()->bloodtypes()->sync($request->blood_types);
        }
        $data = [
            'governorates' => $request->client()->governorates()->pluck('governorates.id')->toArray(),
            'blood_types' => $request->client()->bloodtypes()->pluck('blood_types.id')->toArray(),
        ];
        return responseJson(1,'تم  التعديل',$data);
    }






























}

























        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
