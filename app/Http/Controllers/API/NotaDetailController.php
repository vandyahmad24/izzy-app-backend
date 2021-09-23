<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\NotaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotaDetailController extends Controller
{
    public function index($nota_id)
    {
        $notaDetail = NotaDetail::where('nota_id',$nota_id)->get();
        if(!$notaDetail) {
            return ResponseFormatter::error([
                "message"=>"NotaDetail dengan kategori Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $total =NotaDetail::where('nota_id',$nota_id)->sum('total');
        


        return ResponseFormatter::success([
            'NotaDetail'=>$notaDetail,
            'Total'=>$total
        ]);
    }
    public function store(Request $request)
    {
       
        $validator= Validator::make(request()->all(),[
            'nota_id'=>['required','exists:nota,id'],
            'nama'=>['required','string'],
            'harga'=>['required','integer'],
            'qty'=>['required','integer'],
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $data = $request->all();
        $data["total"] = $request->qty*$request->harga;
        $notaDetail = NotaDetail::create($data);
        return ResponseFormatter::success([
            'NotaDetail'=>$notaDetail
        ]);


    }
    public function edit($id)
    {
        $notaDetail=NotaDetail::find($id);

        if(!$notaDetail) {
            return ResponseFormatter::error([
                "message"=>"notaDetail Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        
        return ResponseFormatter::success([
            'NotaDetail'=>$notaDetail
        ]);
    }

    public function update(Request $request, $id)
    {
        $notaDetail=NotaDetail::find($id);
        if(!$notaDetail) {
            return ResponseFormatter::error([
                "message"=>"notaDetail Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $validator= Validator::make(request()->all(),[
            'nota_id'=>['required','exists:nota,id'],
            'nama'=>['required','string'],
            'harga'=>['required','integer'],
            'qty'=>['required','integer'],
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $data=$request->all();
        $data["total"]=$request->qty*$request->harga;
        $notaDetail->update($data);

        return ResponseFormatter::success([
            'NotaDetail'=>$notaDetail
        ]);
    }
    public function destroy($id)
    {
        $notaDetail=NotaDetail::find($id);
        if(!$notaDetail) {
            return ResponseFormatter::error([
                "message"=>"NotaDetail Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $notaDetail->delete();
        return ResponseFormatter::success([
            // 'notaDetail'=>$notaDetail
        ],"NotaDetail Berhasil dihapus");

    }
}
