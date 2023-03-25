<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('v_mahasiswa.create', [
            'title' => 'Tambah Data mahasiswa',
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
            'nomor_induk' => 'required',
            'angkatan' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'konfir' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($validatedData['password'] == $validatedData['konfir']) {
            if ($request->file('upload')) {
                $validatedData['upload'] = $request->file('upload')->store('mahasiswa-images');
            }

            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'nomor_induk' => $validatedData['nomor_induk'],
                'nama' => $validatedData['nama'],
                'role' => 'mahasiswa'
            ]);
        } else {
            return redirect('/mahasiswa/create')->with('fail', 'Konfirmasi Password harus sama dengan Password');
        }

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
        return view('v_mahasiswa.edit', [
            'title' => 'Edit Data mahasiswa',
            'mahasiswa' => $mahasiswa
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
            'nomor_induk' => 'required',
            'angkatan' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $mahasiswa->user->email) {
            $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:users']);
        } else {
            $validatedData['email'] = $request->validate(['email' => 'nullable']);
        }

        if ($request->has(['baru', 'lama', 'konfir'])) {
            $validatedData['lama'] = $request->validate(['lama' => 'required']);
            $validatedData['baru'] = $request->validate(['baru' => 'required']);
            $validatedData['konfir'] = $request->validate(['konfir' => 'required']);
            $lama = bcrypt($request->lama);
            $baru = bcrypt($request->baru);
            $konfir = bcrypt($request->konfir);

            return dd(bcrypt('cepi') == bcrypt('cepi'));

            if ($lama == $mahasiswa->user->password) {
                if ($baru == $konfir) {
                    $user = User::create([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                        'nomor_induk' => $validatedData['nomor_induk'],
                        'nama' => $validatedData['nama'],
                        'role' => 'mahasiswa'
                    ]);
                } else {
                    return redirect('/mahasiswa/' . $mahasiswa->id . '/edit')->with('fail', 'Konfirmasi Password harus sama dengan Password');
                }
            } else {
                return redirect('/mahasiswa/' . $mahasiswa->id . '/edit')->with('fail', 'Password Salah');
            }
        }

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('mahasiswa-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'nama' => $validatedData['nama'],
            'role' => 'mahasiswa'
        ]);

        unset($validatedData['email']);
        unset($validatedData['lama']);
        unset($validatedData['baru']);
        unset($validatedData['konfir']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        mahasiswa::create($validatedData);
        return redirect('/mahasiswa')->with('success', 'Tambah Data mahasiswa Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto) {
            Storage::delete($mahasiswa->foto);
        }

        mahasiswa::destroy($mahasiswa->id);
        User::destroy($mahasiswa->user->id);
        return redirect('/mahasiswa')->with('success', 'Data mahasiswa telah dihapus');
    }
}
