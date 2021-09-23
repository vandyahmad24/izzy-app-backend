<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index($kategori_id)
    {
        $stok = Stok::where('kategori_id',$kategori_id)->get();
        if(!$stok) {
            return ResponseFormatter::error([
                "message"=>"Stok dengan kategori Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        return ResponseFormatter::success([
            'stok'=>$stok
        ]);
    }
    public function store(Request $request)
    {
       
        $validator= Validator::make(request()->all(),[
            'kategori_id'=>['required','exists:kategori,id'],
            'nama'=>['required','string'],
            'qty_22'=>['required','integer'],
            'qty_33'=>['required','integer'],
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $data = $request->all();
        $stok = Stok::create($data);
        return ResponseFormatter::success([
            'stok'=>$stok
        ]);


    }
    public function edit($id)
    {
        $stok=Stok::find($id);

        if(!$stok) {
            return ResponseFormatter::error([
                "message"=>"Stok Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        
        return ResponseFormatter::success([
            'stok'=>$stok
        ]);
    }

    public function update(Request $request, $id)
    {
        $stok=Stok::find($id);
        if(!$stok) {
            return ResponseFormatter::error([
                "message"=>"Stok Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $validator= Validator::make(request()->all(),[
            'kategori_id'=>['required','exists:kategori,id'],
            'nama'=>['required','string'],
            'qty_22'=>['required','integer'],
            'qty_33'=>['required','integer'],
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $data=$request->all();
        $stok->update($data);

        return ResponseFormatter::success([
            'stok'=>$stok
        ]);
    }
    public function destroy($id)
    {
        $stok=Stok::find($id);
        if(!$stok) {
            return ResponseFormatter::error([
                "message"=>"stok Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $stok->delete();
        return ResponseFormatter::success([
            // 'stok'=>$stok
        ],"stok Berhasil dihapus");

    }



}
