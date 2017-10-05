<?php

namespace App\Http\Controllers\Admin;

use App\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class InspiracerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = Person::all();
        return view('admin.pages.person.index',compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.person.create');
    }

    public function uploadVideo(Request $request)
    {
//        return response()->json($request->file('video')->getClientSize());
//        if($request->hasFile('video')){
        $file = $request->file('video');
        $filename = 'loop-'.Carbon::now()->timestamp.'.'.$request->file('video')->getClientOriginalExtension();
        $path = public_path().'/assets/media/loopvideo/';
        $file->move($path, $filename);
        return response()->json(['status' => 'success', 'filename' => $filename],200);
//        }
//        return response()->json('failed');
//        echo $request->file('video')->getClientOriginalName();
//        echo $request->video->extension();
//        return response()->json($request->file('video')->extension());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'thumbnail_list' => 'required|file|image',
            'thumbnail_1' => 'required|file|image',
            'thumbnail_2' => 'required|file|image',
            'thumbnail_3' => 'required|file|image',
            'background_1' => 'required|file|image',
            'background_2' => 'required|file|image',
            'youtube' => 'required|youtube',
            'nama' => 'required',
            'posisi' => 'required',
            'text_1' => 'required',
            'text_2' => 'required',
            'text_3' => 'required',
            'feature_1' => 'required',
            'feature_2' => 'required',
            'feature_3' => 'required',
        ],['youtube.youtube' => 'Link Youtube Harus Valid']);
        if($request->hasFile('thumbnail_list')){
            if ($request->file('thumbnail_list')->isValid()){
                $extension = $request->thumbnail_list->extension();
                $filename = 'list-'.Carbon::now()->timestamp.'.'.$extension;
                $request->thumbnail_list->storeAs('/img-list',$filename);
                $thumb_list = $filename;
            }
        }
        $background = array();
        for ($i = 1; $i < 3; $i++){
            if($request->hasFile('background_'.$i)){
                if ($request->file('background_'.$i)->isValid()){
                    $extension = $request->file('background_'.$i)->extension();
                    $filename = 'background_'.$i.'-'.Carbon::now()->timestamp.'.'.$extension;
                    $request->file('background_'.$i)->storeAs('/background',$filename);
                    $background[] = $filename;
                }
            }
        }
        $thumbnail = array();
        for ($i = 1; $i < 4; $i++){
            if($request->hasFile('thumbnail_'.$i)){
                if ($request->file('thumbnail_'.$i)->isValid()){
                    $extension = $request->file('thumbnail_'.$i)->extension();
                    $filename = 'thumbnail_'.$i.'-'.Carbon::now()->timestamp.'.'.$extension;
                    $request->file('thumbnail_'.$i)->storeAs('/thumbnail',$filename);
                    $thumbnail[] = $filename;
                }
            }
        }
        $slug = str_slug($request->input('nama'));
        if (isset($request->youtube)){
            if (strpos($request->input('youtube'), 'youtube.com/watch?v=') !== false) {
                $video = explode("v=", $request->input('youtube'));
                $youtube_code = explode("&", $video[1]);
                $youtube_id = $youtube_code[0];

            } elseif (strpos($request->input('youtube'), 'youtube.com/embed/') !== false) {
                $video = explode("embed/", $request->input('youtube'));
                $youtube_code = explode("?", $video[1]);
                $youtube_id = $youtube_code[0];

            } elseif (strpos($request->input('youtube'), 'youtu.be/') !== false) {
                $video = explode("be/", $request->input('youtube'));
                $youtube_code = explode("?", $video[1]);
                $youtube_id = $youtube_code[0];
            }
        }

        Person::create([
            'nama' => $request->input('nama'),
            'posisi' => $request->input('posisi'),
            'slug' => $slug,
            'youtube_id' => isset($youtube_id) ? $youtube_id : null,
            'loopvid_home_desktop' => $request->input('home-loop-desktop') != null ? $request->input('home-loop-desktop') : null,
            'loopvid_home_mobile' => $request->input('home-loop-mobile') != null ? $request->input('home-loop-mobile') : null,
            'loopvid_desktop' => $request->input('detail-loop-desktop') != null ? $request->input('detail-loop-desktop') : null,
            'loopvid_mobile' => $request->input('detail-loop-mobile') != null ? $request->input('detail-loop-mobile') : null,
            'feature_teks_1' => $request->input('feature_1'),
            'teks_1' => $request->input('text_1'),
            'feature_teks_2' => $request->input('feature_2'),
            'teks_2' => $request->input('text_2'),
            'feature_teks_3' => $request->input('feature_3'),
            'teks_3' => $request->input('text_3'),
            'thumbnail_img_list' => isset($thumb_list) ? $thumb_list : null,
            'thumbnail_img_1' => isset($thumbnail[0]) ? $thumbnail[0] : null,
            'thumbnail_img_2' => isset($thumbnail[1]) ? $thumbnail[1] : null,
            'thumbnail_img_3' => isset($thumbnail[2]) ? $thumbnail[2] : null,
            'background_img_1' => isset($background[0]) ? $background[0] : null,
            'background_img_2' => isset($background[1]) ? $background[1] : null,
        ]);
        return redirect('/admin/person');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $person = Person::find($id);
//        return view('admin.pages.person.show',compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person = Person::find($id);
        return view('admin.pages.person.edit',compact('person'));
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
        $this->validate($request,[
            'thumbnail_list' => 'sometimes|file|image',
            'thumbnail_1' => 'sometimes|file|image',
            'thumbnail_2' => 'sometimes|file|image',
            'thumbnail_3' => 'sometimes|file|image',
            'background_1' => 'sometimes|file|image',
            'background_2' => 'sometimes|file|image',
            'youtube' => 'required|youtube',
            'nama' => 'required',
            'posisi' => 'required',
            'text_1' => 'required',
            'text_2' => 'required',
            'text_3' => 'required',
            'feature_1' => 'required',
            'feature_2' => 'required',
            'feature_3' => 'required',
        ],['youtube.youtube' => 'Link Youtube Harus Valid']);
        $person = Person::find($id);
        if($request->hasFile('thumbnail_list')){
            if ($request->file('thumbnail_list')->isValid()){
                $extension = $request->thumbnail_list->extension();
                $filename = 'list-'.Carbon::now()->timestamp.'.'.$extension;
                $request->thumbnail_list->storeAs('/img-list',$filename);
                Storage::delete('/img-list/'.$person->thumbnail_img_list);
                $person->thumbnail_img_list = $filename;
            }
        }
        if($request->hasFile('background_1')){
            if ($request->file('background_1')->isValid()){
                $extension = $request->file('background_1')->extension();
                $filename = 'background_1-'.Carbon::now()->timestamp.'.'.$extension;
                $request->file('background_1')->storeAs('/background',$filename);
                Storage::delete('/background/'.$person->background_img_1);
                $person->background_img_1 = $filename;
            }
        }
        if($request->hasFile('background_2')){
            if ($request->file('background_2')->isValid()){
                $extension = $request->file('background_2')->extension();
                $filename = 'background_2-'.Carbon::now()->timestamp.'.'.$extension;
                $request->file('background_2')->storeAs('/background',$filename);
                Storage::delete('/background/'.$person->background_img_2);
                $person->background_img_2 = $filename;
            }
        }
        if($request->hasFile('thumbnail_1')){
            if ($request->file('thumbnail_1')->isValid()){
                $extension = $request->file('thumbnail_1')->extension();
                $filename = 'thumbnail_1-'.Carbon::now()->timestamp.'.'.$extension;
                $request->file('thumbnail_1')->storeAs('/thumbnail',$filename);
                Storage::delete('/thumbnail/'.$person->thumbnail_img_1);
                $person->thumbnail_img_1 = $filename;
            }
        }
        if($request->hasFile('thumbnail_2')){
            if ($request->file('thumbnail_2')->isValid()){
                $extension = $request->file('thumbnail_2')->extension();
                $filename = 'thumbnail_2-'.Carbon::now()->timestamp.'.'.$extension;
                $request->file('thumbnail_2')->storeAs('/thumbnail',$filename);
                Storage::delete('/thumbnail/'.$person->thumbnail_img_2);
                $person->thumbnail_img_2 = $filename;
            }
        }
        if($request->hasFile('thumbnail_3')){
            if ($request->file('thumbnail_3')->isValid()){
                $extension = $request->file('thumbnail_3')->extension();
                $filename = 'thumbnail_3-'.Carbon::now()->timestamp.'.'.$extension;
                $request->file('thumbnail_3')->storeAs('/thumbnail',$filename);
                Storage::delete('/thumbnail/'.$person->thumbnail_img_3);
                $person->thumbnail_img_3 = $filename;
            }
        }
        $slug = str_slug($request->input('nama'));
        if (isset($request->youtube)) {
            $video = explode("v=", $request->input('youtube'));
            $youtube_code = explode("&", $video[1]);
            $youtube_id = $youtube_code[0];
            $person->youtube_id = $youtube_id;
        }

        if ($request->input('home-loop-desktop') != null){
            $old = $person->loopvid_home_desktop;
            if ($old != null){
                Storage::delete('/loopvideo/'.$old);
            }
            $person->loopvid_home_desktop = $request->input('home-loop-desktop');
        }

        if ($request->input('home-loop-mob') != null){
            $old = $person->loopvid_home_mobile;
            if ($old != null) {
                Storage::delete('/loopvideo/' . $old);
            }
            $person->loopvid_home_mobile = $request->input('home-loop-mob');
        }
        if ($request->input('detail-loop-desktop') != null){
            $old = $person->loopvid_desktop;
            if ($old != null) {
                Storage::delete('/loopvideo/' . $old);
            }
            $person->loopvid_desktop = $request->input('detail-loop-desktop');
        }

        if ($request->input('detail-loop-mob') != null){
            $old = $person->loopvid_mobile;
            if ($old != null) {
                Storage::delete('/loopvideo/' . $old);
            }
            $person->loopvid_mobile = $request->input('detail-loop-mob');
        }

        $person->nama = $request->input('nama');
        $person->posisi = $request->input('posisi');
        $person->slug = $slug;
        $person->feature_teks_1 = $request->input('feature_1');
        $person->teks_1 = $request->input('text_1');
        $person->feature_teks_2 = $request->input('feature_2');
        $person->teks_2 = $request->input('text_2');
        $person->feature_teks_3 = $request->input('feature_3');
        $person->teks_3 = $request->input('text_3');
        $person->save();

        return redirect('/admin/person');
    }

    public function active($id)
    {
        $person = Person::find($id);
        $person->is_active = 1;
        $person->save();
        return redirect('/admin/person');
    }

    public function deactive($id)
    {
        $person = Person::find($id);
        $person->is_active = 0;
        $person->save();
        return redirect('/admin/person');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
