<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Mahasiswa;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $dosen = Dosen::where('user_id', $user->id)->first();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $staff = Staff::where('user_id', $user->id)->first();
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $user->email) {
            $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:users']);
        } else {
            $validatedData['email'] = $request->validate(['email' => 'required']);
        }

        if ($request->nomor_induk != $user->nomor_induk) {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required|unique:users']);
        } else {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required']);
        }

        if ($request->password) {
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('password', 'The password field is incorrect');
            }
            $validatedData['new_password'] = $request->validate(['new_password' => 'required']);
            $validatedData['new_password_confirmation'] = $request->validate(['new_password_confirmation' => 'required|same:new_password']);
            $password = Hash::make($request->new_password);
        } else {
            $password = $user->password;
        }

        if ($request->file('upload')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['upload'] = $request->file('upload')->store('user-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        } else {
            $validatedData['foto'] = $request->oldImage;
        }

        User::find($user->id)->update([
            'email' => $request->email,
            'password' => $password,
            'nomor_induk' => $request->nomor_induk,
            'foto' => $validatedData['foto'],
            'nama' => $request->nama,
        ]);

        if ($user->role == 'dosen') {
            Dosen::find($dosen->id)->update([
                'foto' => $validatedData['foto'],
            ]);
        } elseif ($user->role == 'mahasiswa') {
            Mahasiswa::find($mahasiswa->id)->update([
                'foto' => $validatedData['foto'],
            ]);
        } elseif ($user->role == 'staff') {
            $validatedData['bidang'] = $request->validate(['bidang' => 'required']);
            Staff::find($staff->id)->update([
                'bidang' => $request->bidang,
                'foto' => $validatedData['foto'],
            ]);
        }

        return redirect('/profil')->with('success', 'Ubah Profil Berhasil');
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
        $user = User::find(auth()->user()->id);
        $dosen = Dosen::where('user_id', $user->id)->first();
        $laboratorium = Laboratorium::where('user_id', $user->id)->first();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        $staff = Staff::where('user_id', $user->id)->first();
        return view('v_profil', [
            'title' => 'Profil',
            'user' => $user,
            'dosen' => $dosen,
            'laboratorium' => $laboratorium,
            'mahasiswa' => $mahasiswa,
            'staff' => $staff
        ]);
    }
}
