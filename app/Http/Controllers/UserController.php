<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        $user = User::IsNotAdmin()->orderBy('id', 'DESC')->get();

            return datatables()
                ->of($user)
                ->addIndexColumn()                
                ->addColumn('aksi', function($user) { 
                    return '
                        <button onclick="editData(`'. route('users.update', $user->id).'`)" class="btn btn-xs btn-success btn-flat><i class=bi bi-pencil-square"> Edit<i/></button> 
                        <button onclick="deleteForm(`'. route('users.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"> Hapus</i></button>
                        '; 
                    })
                ->rawColumns(['aksi'])
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
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level= 2;
        // $user->foto = $request->foto;
        $user->foto = '/images/monster.png';
        $user->save();

        // $validateData = $request->validate([
        //     'user' => 'required',
        //     'name' => 'required',
        //     'username' => 'required',
        //     'email' => 'required|email:dns',
        //     'password' => 'required',
        //     'foto' => 'image|file|max:1024'
        // ]);

        // $validateData['password'] = Hash::make($validateData['password']);

        // if($request->file('foto')) {
        //     $validateData['foto'] = $request->file('image');
        // } 

        // User::create($validateData);

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != "" ) {
            $user->request = $request->password;
        }
        $user->update();

        return response()->json('Data berhasil diubah', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response(null,204);
    }
}
