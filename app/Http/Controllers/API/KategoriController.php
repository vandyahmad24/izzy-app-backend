<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::orderBy('updated_at','desc')->get();
        // dd($kategori);
        return ResponseFormatter::success($kategori,"success");
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
    public function store(Request $request)
    {
        $validator= Validator::make(request()->all(),[
            'nama'=>'required',
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $kategori = new Kategori();
        $kategori->nama=$request->nama;
        $kategori->save();
        return ResponseFormatter::success([
            'kategori'=>$kategori
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
        $kategori=Kategori::find($id);

        if(!$kategori) {
            return ResponseFormatter::error([
                "message"=>"Kategori Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        
        return ResponseFormatter::success([
            'kategori'=>$kategori
        ]);
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
        $kategori=Kategori::find($id);
        if(!$kategori) {
            return ResponseFormatter::error([
                "message"=>"Kategori Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $validator= Validator::make(request()->all(),[
            'nama'=>'required',
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $kategori->nama = $request->nama;
        $kategori->save();
        
        return ResponseFormatter::success([
            'kategori'=>$kategori
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
        $kategori=Kategori::find($id);
        if(!$kategori) {
            return ResponseFormatter::error([
                "message"=>"Kategori Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $kategori->delete();
        return ResponseFormatter::success([
            // 'kategori'=>$kategori
        ],"Kategori Berhasil dihapus");

    }
}
