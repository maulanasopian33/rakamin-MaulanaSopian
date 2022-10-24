<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Articles;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = '';
        try {
            $show = Articles::get()->all();
            $status = true;
        } catch (\Exception $e) {
            $status = false;
            $message = $e;
        }
        $respon = [
            'status'    => $status,
            'message'   => $message,
            'data'      => $show
        ];
        return response()->json($respon);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileName   = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/image'), $fileName);
        $data       = [
                            'title'         => $request->title,
                            'content'       => $request->content,
                            'image'         => '/uploads/image/'.$fileName,
                            'category_id'   => $request->category_id,
                            'user_id'       => $request->user_id
                        ];
        try {
            $create = Articles::create($data);
            $respon = [
                'status'    => true,
                'message'   => 'Artikel berhasil disimpan',
                'data'      => $data
            ];
        } catch (\Exception $e) {
            $respon = [
                'status'    => false,
                'message'   => 'Artikel gagal disimpan',
                'data'      => $e->getMessage()
            ];
        }
        return response()->json($respon);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\API\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artikel = Articles::firstwhere('id',$id);
        $message = 'Artikel tersedia';
        $respon = [
            'status'    => true,
            'message'   => $message,
            'data'      => $artikel
        ];
        return response()->json($respon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\API\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        try {
            $artikel   = Articles::find($id);
            $url       = $artikel->image;
            if($request->hasFile('image')) {
                $fileName  = time().'_'.$request->image->getClientOriginalName();
                $url       = '/uploads/image'.$fileName;
                $upload    = $request->image->move(public_path('uploads/image'), $fileName);
            }
            $artikel->title         = $request->title;
            $artikel->content       = $request->content;
            $artikel->image         = $url;
            $artikel->category_id   = $request->category_id;
            $artikel->save();

            $respon = [
                'status'    => true,
                'message'   => 'Artikel berhasil diupdate',
                'data'      => $artikel
            ];
        } catch (\Exception $e) {
            $respon = [
                'status'    => false,
                'message'   => 'Artikel gagal diupdate',
                'data'      => $e->getMessage()
            ];
        }

        return response()->json($respon,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\API\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Articles::find($id);
        if (is_null($post)) {
            $respon = [
                'status'    => false,
                'message'   => "Artikel tidak ditemukan"
            ];
            return response()->json($respon);
        }
        $post->delete();
        if (File::exists($post)) {
            File::delete($post);
        }
        $message = "Artikel dengan Id = ".$id." berhasil di hapus";
        $respon = [
            'status'    => true,
            'message'   => $message
        ];
        return response()->json($respon);
    }
}
