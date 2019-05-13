<?php








class MainController extends Controller
{

    public function governorates()
    {
        $governorates= Governorate::all();
        return responseJson(1, 'success', $governorates);

    }

    public function cities(Request $request)
    {
        // $cities = City::where(('governorate_id',$request->governorate_id)->get();
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();
        return responseJson(1, 'success', $cities);
    }


public function posts(Request  $request){
    $posts = Post::all();
        $posts = post::With('category')->Where(function ($query)use($request){

            if ($request->has('category_id')) {

                $query->where('category_id', $request->category_id);
            }

if($request->has('keyword'))
{
    $query->where(function($query2) use($request){
        $query2->where('title','like','%'.$request->keyword.'%');
        $query2->orWhere('content','like','%'.$request->keyword.'%');
    });
}
})->latest()->paginate(10);
return responseJson(1 , 'success' , $posts);
}


    public function post_details($id)
    {
        //$post = Post::find($id);
        $post = Post::with(['category' => function ($query) use($id) {
            $query->where('id','=',$id);
        }])->get();
        if($post){
            return responseJson(1 ,'Details Of Post' ,$post);
        }
        return responseJson(0 ,'Not Found');
    }


    public function donationRequests(Request $request)
    {

        $donations = DonationRequest::with('cites', 'clients','blood_Types','notifications')->where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->whereHas('city', function ($query) use($request){
                    $query->where('governorate_id',$request->governorate_id);
                });
            }elseif ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->has('blood_type_id')) {
                $query->where('blood_type_id', $request->blood_type_id);
            }
        })->latest()->paginate(10);
        return responseJson(1, 'success', $donations);

}

    public function bloodTypes()
    {
        $bloodTypes = BloodType::all();
        return responseJson(1, 'success', $bloodTypes);
    }

public function donationRequestCreat(Request $request)
{
    $rules = [

        'client_id' => 'required' | 'unsigned',
        'name' => 'required',
        'patient_age' => 'required:digits',
        'blood_type_id' => 'required|exists:blood_types,id',
        'required_amount' => 'required:digits',
        'address' => 'required',
        'last_donation' => 'required|date_format:Y-m-d',
        'phone' => 'required|digits:11',
        'details' => 'required,min:10'
    ];


    $validator = validator()->make($request->all(), $rules);
    if ($validator->fails()) {
        return responseJson(0, $validator->errors()->first(), $validator->errors());
    }

}

    public function listOfNotificatios()
{
    $notification = Notification::with(['donation_requests', 'clients:name'])->paginate(15);
    return responseJson(1, 'List Of Notifications', $notification);
}

    public function postFavourite(Request $request)
    {
        $rules = ['post_id' => 'required|exists:posts,id'];
        $validator = validator()->make($request->all(), $rules);
        if($validator->fails())
        {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $togglePost = $request->user()->posts()->toggle($request->post_id);
        return responseJson(1, 'Success', $togglePost);
    }




    public function myFavourites(Request $request)
    {
        $posts = $request->user()->posts()->with('category')->latest()->paginate(20);
        return responseJson(1, 'Loading....', $posts);
    }


    public function Setting(){
        $settings = Settings::all();

        return responseJson(1 , 'Settings' , $settings);
    }













}



