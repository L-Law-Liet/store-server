<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $name = '';
        if($file = $request->file('image')) {
            $dir = 'news/';
            $name = env('STORAGE_PATH') . $dir . time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public') .  '/'.$dir, $name);
        }
        $data = $request->validated();
        $data['image'] = $name;
        return News::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return News::findOrFail($id);
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
    public function update(News $news, NewsRequest $request)
    {
        if ($request->file('image')){
            return 1;
        }
        return $request->all();
        $dir = 'news/';
        $data = $request->validated();
        $data['image'] = $news->image;
        if($file = $request->file('image')) {

            $image = str_replace(env('STORAGE_PATH'), '', $news->image);
            if (\Storage::disk('public')->exists($image)){
                \Storage::disk('public')->delete($image);
            }
            $name = env('STORAGE_PATH').$dir . time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public') . '/'.$dir, $name);

            $data['image'] = $name;
        }
        return $news->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return News::findOrFail($id)->delete();
    }



    public function getPageable(){
        return News::paginate(5);
    }

}
