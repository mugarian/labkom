<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('v_mahasiswa.index', [
            'title' => 'Kelola Data mahasiswa',
            'mahasiswas' => $mahasiswa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::orderBy('angkatan', 'desc')->get();
        return view('v_mahasiswa.create', [
            'title' => 'Tambah Data mahasiswa',
            'kelas' => $kelas,
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
            'nama' => 'required|max:255',
            'nomor_induk' => 'required|unique:users',
            'kelas_id' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'password_confirmation' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('user-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'nama' => $validatedData['nama'],
            'foto' => $validatedData['foto'],
            'role' => 'mahasiswa'
        ]);

        unset($validatedData['email']);
        unset($validatedData['password']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        mahasiswa::create($validatedData);
        return redirect('/mahasiswa')->with('success', 'Tambah Data mahasiswa Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('v_mahasiswa.show', [
            'title' => $mahasiswa->user->nama,
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $kelas = Kelas::where('id', '<>', $mahasiswa->kelas_id)->orderBy('angkatan', 'desc')->get();
        return view('v_mahasiswa.edit', [
            'title' => 'Edit Data mahasiswa',
            'mahasiswa' => $mahasiswa,
            'kelas' => $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kelas_id' => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $mahasiswa->user->email) {
            $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:users']);
        } else {
            $validatedData['email'] = $request->validate(['email' => 'required']);
        }

        if ($request->nomor_induk != $mahasiswa->user->nomor_induk) {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required|unique:users']);
        } else {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required']);
        }

        if ($request->password) {
            if (!Hash::check($request->password, $mahasiswa->user->password)) {
                return back()->with('password', 'The password field is incorrect');
            }
            $validatedData['new_password'] = $request->validate(['new_password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()]]);
            $validatedData['new_password_confirmation'] = $request->validate(['new_password_confirmation' => 'required|same:new_password']);
            $password = Hash::make($request->new_password);
        } else {
            $password = $mahasiswa->user->password;
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

        User::find($mahasiswa->user->id)->update([
            'email' => $request->email,
            'password' => $password,
            'nomor_induk' => $request->nomor_induk,
            'nama' => $request->nama,
            'foto' => $validatedData['foto'],
            'role' => 'mahasiswa'
        ]);

        unset($validatedData['email']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $mahasiswa->user->id;

        mahasiswa::find($mahasiswa->id)->update($validatedData);
        return redirect('/mahasiswa')->with('success', 'Ubah Data mahasiswa Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            if ($mahasiswa->foto) {
                Storage::delete($mahasiswa->foto);
            }

            $user = User::destroy($mahasiswa->user->id);
            if ($user) {
                mahasiswa::destroy($mahasiswa->id);
            }

            return redirect('/mahasiswa')->with('success', 'Data mahasiswa telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/mahasiswa')->with('fail', 'Gagal Menghapus Data Karena Data Terhubung dengan Data Lain');
        }
    }
}
