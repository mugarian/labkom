<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'title' => 'Kelola Akun',
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', [
            'title' => 'Tambah Akun'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_induk' => 'required|max:255|unique:users|alpha_num',
            'name' => 'required|max:255',
            'jabatan' => 'required',
            'kelas_id' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:16384',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'no_hp' => 'required|unique:users',
            'alamat' => 'nullable'
        ]);

        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('user-images');
        }
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);

        return redirect('/akun')->with('success', 'Tambah Data Akun Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($ni)
    {
        $user = User::where('nomor_induk', $ni)->first();
        return view('user.show', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($ni)
    {
        $user = User::where('nomor_induk', $ni)->first();
        return view('user.edit', [
            'title' => 'Edit Akun',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ni)
    {
        $user = User::where('nomor_induk', $ni)->first();
        $rules = [
            'name' => 'required|max:255',
            'jabatan' => 'required',
            'kelas_id' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:16384',
            'password' => 'required',
            'alamat' => 'nullable'
        ];

        if ($request->nomor_induk != $user->nomor_induk) {
            $rules['nomor_induk'] = 'required|max:255|unique:users|alpha_num';
        }

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->no_hp != $user->no_hp) {
            $rules['no_hp'] = 'required|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('gambar')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('user-images');
        }
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::where('nomor_induk', $user->nomor_induk)->first()->update($validatedData);

        return redirect('/akun')->with('success', 'Ubah Data Akun Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($ni)
    {
        $user = User::where('nomor_induk', $ni)->first();
        if ($user->image) {
            Storage::delete($user->image);
        }

        if (auth()->user()->id == $user->id) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            User::destroy($user->id);
            return redirect('/logint')->with('success', 'Hapus Data Akun Berhasil');
        } else {
            User::destroy($user->id);
            return redirect('/akun')->with('success', 'Hapus Data Akun Berhasil');
        }
    }

    public function profil()
    {
        return view('user.profil', [
            'title' => 'Profil',
            'user' => auth()->user()
        ]);
    }
}
