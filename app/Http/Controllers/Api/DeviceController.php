<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Storage;
use App\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::all();
        foreach($devices as $key => $dev){
            $devices[$key]['image'] = '/public/storage/'.$dev->id.'/'.$dev->image;
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $devices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|max:100|string',
            'description' => 'required|max:100|string',
            'selectedfield' => ['required', Rule::in(['field1', 'field2'])],
            'availability' => ['required', Rule::in(['0', '1'])],
        ]);

        if ( $validator->fails() ) {
            return response()->json([
            'data' => [
                'success' => FALSE,
                'errors' => $validator->errors(),
                ]
            ]);
        }

        $device = Device::create([
            'name' => $request->name,
            'description' => $request->description,
            'field' => $request->selectedfield,
            'availability' => $request->availability
        ]);

        $image = $request->get('dev_image');
        $image_name = time().'.'.$request->dev_image->extension();
        $request->dev_image->move(public_path('/storage/'.$device->id), $image_name);

        $device->image = $image_name;
        $device->save();

        $device->image = '/public/storage/'.$device->id.'/'.$device->image;

        return response()->json([
            'success' => TRUE,
            'message' => "Added Device",
            'data' => $device,
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make( $request->all(), [
            'name' => 'required|max:100|string',
            'description' => 'required|max:100|string',
            'selectedfield' => ['required', Rule::in(['field1', 'field2'])],
            'availability' => ['required', Rule::in(['0', '1'])],
        ]);

        if ( $validator->fails() ) {
            return response()->json([
            'data' => [
                'success' => FALSE,
                'errors' => $validator->errors(),
                ]
            ]);
        }

        $device = Device::find($id);
        $device->name = $request->name;
        $device->description = $request->description;
        $device->field = $request->selectedfield;
        $device->availability = $request->availability;

        if(isset($request->dev_image)){
            unlink(public_path('storage/'.$device->id.'/'.$device->image));
            $image = $request->get('dev_image');
            $image_name = time().'.'.$request->dev_image->extension();
            $request->dev_image->move(public_path('/storage/'.$device->id), $image_name);
            $device->image = $image_name;
        }
       
        $device->save();

        $device->image = '/public/storage/'.$device->id.'/'.$device->image;

        return response()->json([
            'success' => TRUE,
            'data' => $device,
            'message' => "Device Updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = Device::find($id);
        if($device != null){
            $device->delete();
            unlink(public_path('storage/'.$device->id.'/'.$device->image));
            rmdir(public_path('storage/'.$device->id));
            return response()->json([
                'success' => TRUE,
                'message' => "Device Deleted"
            ]);
        }
        return response()->json([
            'success' => FALSE,
            'message' => "Something wenr wrong, please refresh your page"
        ]);
    }
}
