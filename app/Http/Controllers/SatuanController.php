<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('satuan.index');
    }

    public function data()
    {
        $satuan = Satuan::orderBy('id_satuan', 'desc')->get();

        return datatables()
            ->of($satuan)
            ->addIndexColumn()
            ->addColumn('act', function ($satuan) {
                return '
                <button onclick="edit(`'. route('satuan.update', $satuan->id_satuan) .'`)" class="btn btn-xs btn-success btn-flat"><i class="bi bi-pencil-square"> Edit</i></button>
                <button onclick="deleteData(`'. route('satuan.destroy', $satuan->id_satuan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"> Hapus</i></button>
                ';
            })
            ->rawColumns(['act'])
            ->make(true);
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
        $satuan = new Satuan();
        $satuan->nama_satuan= $request->nama_satuan;
        $satuan->save();

        return response()->json('Satuan baru berhasil ditambahkan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $satuan = Satuan::find($id);
        
        return response()->json($satuan);
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
    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);
        $satuan->nama_satuan = $request->nama_satuan;
        $satuan->update();

        return response()->json('Satuan berhasil diupdate', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();

        return response(null,204);
    }
}
