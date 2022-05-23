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
        $user = User::orderBy('id', 'DESC')->get();

            return datatables()
                ->of($user)
                ->addIndexColumn()              
                ->addColumn('aksi', function($user) {
                    return '
                        <button onclick="editData(`'. route('users.update', $user->id).'`)" class="btn btn-xs btn-success btn-flat><i class=bi bi-pencil-square"></i> Edit</button> 
                        <button onclick="deleteForm(`'. route('users.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="bi bi-trash"></i> Hapus</button>
                        '; 
                    })
                ->rawColumns(['aksi', 'level'])
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
        $user->level= $request->level;
        $user->foto = '/images/monster.png';

        $user->save();

        return response()->json('Pengguna baru berhasil ditambahkan', 200);
        
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
        $user->level = $request->level;
        
        if ($request->has('password') && $request->password != "" ) {
            $user->request = $request->password;
        }
        $user->update();

        return response()->json('Pengguna berhasil diupdate', 200);
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

    public function profile()
    {
        $profile = auth()->user();
        return view('users.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        $request->validate([
            'foto' => 'image|file|max:3072',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/images'), $nama);

            $user->foto = $nama;
        }
        $user->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    // public function profile()
    // {   
    //     $profile = auth()->user();
    //     return view('users.profile', compact('profile'));
    // }

    // public function updateProfile(Request $request)
    // {
    //     $user = auth()->user();

    //     $user->name = $request->name;
    //     $user->username = $request->username;
    //     $user->email = $request->email;

    //     if ($request->hasFile('foto')) {
    //         $file = $request->file('foto');
    //         $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('/images'), $nama);

    //         $user->foto = "/images/$nama";
    //     }

    //     $user->update();

    //     return response()->json('$user', 200);
    // }
    
}
