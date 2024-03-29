<?php

namespace App\Http\Controllers\Dashboard;
use Validator;
use Cache;
use Carbon\Carbon;
use App\Store;
use App\Meta;
use App\Thumbnail;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
class StoreController extends DashboardController
{
    public function index()
    {
        // $stores = Cache::remember('stores', 1,function(){
        //     return Store::orderBy('id','asc')->paginate(10);
        // });
        $stores = Store::orderBy('id','asc')->paginate(10);
        return view('dashboard.store.index',compact(['stores']));
    }

    public function create()
    {
        return view('dashboard.store.create');
    }

    public function store(Request $req)
    {
        $validator_store = Validator::make($req->all(),[
            'store_name' => 'required|unique:stores,store_name',
            'original' => 'required',
            'path_url'=>'required|unique:metas,path_url',
        ],[
            'store_name.required' => 'Store name is required',
            'store_name.unique' => 'This store name has already been taken',
            'original.required'=> 'Store logo is required',
            'path_url.required'=>'Slug is required',
            'path_url.unique'=> 'This slug has already been taken'
        ]
    );
        if($validator_store->passes()){
            $store = new Store;
            $store->store_name = $req->store_name;
            $thumbnail = new Thumbnail;
            $thumbnail->imageable_id = $store->id;
            $thumbnail->original = $req->original;
            $thumbnail->alt = $req->alt;
            $meta = new Meta;
            $meta->metaable_id = $store->id;
            $meta->meta_title = $req->meta_title;
            $meta->meta_description = $req->meta_description;
            $meta->meta_keyword = $req->meta_keyword;
            $meta->canonical = $req->canonical;
            $meta->noindex = $req->noindex;
            $meta->json_ld = $req->json_ld;
            $meta->path_url = $req->path_url;
            $store->save();
            $store->meta()->save($meta);
            $store->thumbnail()->save($thumbnail);
            //Cache::put('stores',$store,Carbon::now());
            return $this->successResponse('Your store has been saved!', 200);
        }else{
            return $this->errorResponse($validator_store->errors()->all(), 406);
        }
    }

    public function show($slug)
    {
        // $store = Store::whereHas('meta',function($q) use ($slug){
        //     $q->where('path_url', $slug);
        // })->get();

        // return response()->json($store); 
    }

    public function edit(Store $store)
    {
        return view('dashboard.store.update', ['store'=>$store]);
    }

    public function update(Request $req, Store $store)
    {
        $validator_store = Validator::make($req->all(),[
            'store_name' => 'required|unique:stores,store_name,'. $store->id,
            'path_url'=>'required|unique:metas,path_url,'. $store->meta->id
        ],[
            'store_name.required' => 'Store name is required',
            'store_name.unique' => 'This store name has already been taken',
            'path_url.required'=>'Slug is required',
            'path_url.unique'=> 'This slug has already been taken'
        ]
 
    );
        if($validator_store->passes()){
            $store->update([
                'store_name' => $req->store_name,
            ]);
            $store->thumbnail()->update([
                'original' => $req->original,
                'alt'=> $req->alt,
            ]);
            $store->meta()->update([
                'meta_title' => $req->meta_title,
                'meta_description'=> $req->meta_description,
                'meta_keyword' => $req->meta_keyword,
                'canonical' => $req->canonical,
                'noindex' => $req->noindex,
                'json_ld' => $req->json_ld,
                'path_url' => $req->path_url,
            ]);

            return $this->successResponse($store->store_name. ' has been updated!', 200);
        }else{
            return $this->errorResponse($validator_store->errors()->all(), 406);
        }
    }

    public function destroy(Store $store)
    {
        //Cache::pull('stores');
        $store->delete();
        $store->deleteMorphResidual();
        return $this->successResponse($store->store_name.' has been deleted', 200);
    }
}
