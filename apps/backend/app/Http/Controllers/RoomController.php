<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Room;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class RoomController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        return RoomResource::collection(Room::with(['roomType', 'hotel'])
                                            ->orderBy('id')
                                            ->get());
    }

    public function show($id)
    {
        $model = Room::with([
            'roomType',
            'hotel'
        ])
                     ->find($id);
        return new RoomResource($model);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'hotel_id' => 'required',
            'room_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            Log::error('Room creation failed with errors: ' . print_r($validator->errors(), true));
            return response($validator->errors(), 400);
        }

        return Room::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = Room::findOrFail($id);
        $model->update($request->all());

        return $model;
    }

    public function destroy(Request $request, $id)
    {
        $model = Room::findOrFail($id);
        $model->delete();

        return 204;
    }
}
