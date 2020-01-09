<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;

class PhotoController extends Controller
{
    /**
     * Create a new photo instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function savePhoto(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'photo' => ['required','string','unique:photos,name','max:255',function ($attribute, $value, $fail) {
                if(!File::exists(storage_path('/app/photos/'.$value))){
                    $fail(':attribute doesnot exist!');
                }
            }],
            'captions' => 'required|string',
            'status' => 'required|in:Draft,Published',
        ]);
        
        
        try {
            $photo = new Photo;
            $photo->name = $request->photo;
            $photo->status = $request->status;
            $photo->captions = $request->captions;
            $photo->user_id = Auth::user()->id;
            if($request->status == 'Published'){
                $photo->published_at = date('Y-m-d H:i:s');
            }
            $photo->save();
            return response()->json(['message' => 'Photo saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not created!'.$e->getMessage()], 422);
        }
    }
    /**
     * Update photo caption.
     *
     * @return Response
     */
    public function updatePhotoCaption(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'captions' => 'required|string',
            'id' => 'exists:photos,id,user_id,'.Auth::user()->id,
        ]);
        
        try {
            Photo::where('id', $request->id)->update(['captions' => $request->captions]);
            return response()->json(['message' => 'Captions updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not found!'.$e->getMessage()], 404);
        }
    }
    /**
     * Publish photo.
     *
     * @return Response
     */
    public function publishPhoto(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'id' => 'exists:photos,id,user_id,'.Auth::user()->id,
        ]);
        
        try {
            Photo::where('id', $request->id)->update(['status' => 'Published', 'published_at' => date('Y-m-d H:i:s')]);
            return response()->json(['message' => 'Photo published successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not found!'.$e->getMessage()], 404);
        }
    }
    /**
     * Get the my photos.
     *
     * @return Response
     */
    public function getMyPhotos()
    {
        return response()->json(['photos' => Photo::where('user_id', Auth::user()->id)->get()], 200);
    }
    /**
     * Get the my photos.
     *
     * @return Response
     */
    public function getMyDrafts()
    {
        return response()->json(['photos' => Photo::where([
            'user_id' =>  Auth::user()->id,
            'status' => 'Draft',
        ])->get()], 200);
    }

    /**
     * Get all photos.
     *
     * @return Response
     */
    public function getAllPhotos(Request $request)
    {
        $order = ($request->order)?$request->order:'asc';
        $where['status'] = 'Published';
        if($request->user_id){
            $where['user_id'] = $request->user_id;
        }
        return response()->json(['photos' =>  Photo::where($where)->orderBy('published_at', $order)
         ->get()], 200);
    }

    /**
     * Get one photo.
     *
     * @return Response
     */
    public function photoDetail($id)
    {
        try {
            $photo = Photo::findOrFail($id);
            return response()->json(['photo' => $photo], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not found!'], 404);
        }
    }
    /**
     * To upload photo
     */
    public function uploadPhoto(Request $request) 
    {
        //validate incoming request 
        $this->validate($request, [
            'photo' => 'required|image|max:2000|dimensions:min_width=250,min_height=500', 
        ]);
        $image = $request->file('photo');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = storage_path('/app/photos');
        try {
            $image->move($destinationPath, $name);
            return response()->json(['photo' => $name], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not uploaded!'.$e->getMessage()], 422);
        }
    }

    /**
     * To delete photo
     */
    public function deletePhoto(Request $request) 
    {
        //validate incoming request 
        $this->validate($request, [
            'id' => 'required|exists:photos,id,user_id,'.Auth::user()->id,
        ]);
        
        try {
            Photo::where('id', $request->id)->delete();
            return response()->json(['message' => 'Photo deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Photo not found!'.$e->getMessage()], 404);
        }
    }
}