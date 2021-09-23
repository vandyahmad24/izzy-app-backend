<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Nota;
use App\Models\NotaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotaController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nota = Nota::orderBy('updated_at','desc')->get();
        // dd($nota);
        return ResponseFormatter::success($nota,"success");
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
            'no'=>'required',
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $nota = new Nota();
        $nota->nama=$request->nama;
        $nota->no=$request->no;
        $nota->save();
        return ResponseFormatter::success([
            'nota'=>$nota
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
        $nota=Nota::find($id);

        if(!$nota) {
            return ResponseFormatter::error([
                "message"=>"nota Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        
        return ResponseFormatter::success([
            'nota'=>$nota
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
        $nota=Nota::find($id);
        if(!$nota) {
            return ResponseFormatter::error([
                "message"=>"nota Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $validator= Validator::make(request()->all(),[
            'nama'=>'required',
            'no' => 'required'
        ]);
        if($validator->fails()) {
            return ResponseFormatter::error([
                "message"=>$validator->messages()->first()
            ],"Data tidak ditemukan",422);
        }
        $nota->nama = $request->nama;
        $nota->no = $request->no;
        $nota->save();
        
        return ResponseFormatter::success([
            'nota'=>$nota
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
        $nota=Nota::find($id);
        if(!$nota) {
            return ResponseFormatter::error([
                "message"=>"nota Tidak ditemukan"
            ],"Data tidak ditemukan",422);
        }
        $nota->delete();
        $notaDetail = NotaDetail::where('nota_id',$id)->get();
        $notaDetail->each->delete();

        return ResponseFormatter::success([
            // 'nota'=>$nota
        ],"nota Berhasil dihapus");

    }
}
