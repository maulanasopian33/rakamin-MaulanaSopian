<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\categories;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CategoriesController extends Controller
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
            $show = categories::get()->all();
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
        $data =[
            'name'      => $request->name,
            'user_id'   => $request->user_id
        ];
        try {
            $create = categories::create($data);
            $respon = [
                'status'    => true,
                'message'   => 'Kategori berhasil disimpan',
                'data'      => $request->all()
            ];
        } catch (\Exception $e) {
            $respon = [
                'status'    => false,
                'message'   => 'Kategori gagal disimpan',
                'data'      => $e->getMessage()
            ];
        }

        return response()->json($respon);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = categories::firstwhere('id',$id);
        $message = 'Kategori tersedia';
        $respon = [
            'status'    => true,
            'message'   => $message,
            'data'      => $category
        ];
        return response()->json($respon);
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
        try {
            $category       = categories::find($id);
            $category->name = $request->name;
            $category->save();
            // $create = categories::update($data);

            $respon = [
                'status'    => true,
                'message'   => 'Kategori berhasil disimpan',
                'data'      => $category
            ];
        } catch (\Exception $e) {
            $respon = [
                'status'    => false,
                'message'   => 'Kategori gagal disimpan',
                'data'      => $e->getMessage()
            ];
        }

        return response()->json($respon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = categories::firstwhere('id',$id);
        if (is_null($category)) {
            $respon = [
                'status'    => false,
                'message'   => "kategori tidak ditemukan"
            ];
            return response()->json($respon);
        }
        $delete = $category->delete();
        $message = "kategori Id =".$id." berhasil di hapus";
        $respon = [
            'status'    => true,
            'message'   => $message
        ];
        return response()->json($respon);
    }
}
