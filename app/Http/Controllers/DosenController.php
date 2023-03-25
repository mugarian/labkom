<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = Dosen::all();
        return view('v_dosen.index', [
            'title' => 'Kelola Data Dosen',
            'dosens' => $dosen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_dosen.create', [
            'title' => 'Tambah Data Dosen',
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
            'jabatan' => 'required',
            'jurusan' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'konfir' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($validatedData['password'] == $validatedData['konfir']) {
            if ($request->file('upload')) {
                $validatedData['upload'] = $request->file('upload')->store('dosen-images');
            }

            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'nomor_induk' => $validatedData['nomor_induk'],
                'nama' => $validatedData['nama'],
                'role' => 'dosen'
            ]);
        } else {
            return redirect('/dosen/create')->with('fail', 'Konfirmasi Password harus sama dengan Password');
        }

        unset($validatedData['email']);
        unset($validatedData['password']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        Dosen::create($validatedData);
        return redirect('/dosen')->with('success', 'Tambah Data Dosen Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        return view('v_dosen.show', [
            'title' => $dosen->user->nama,
            'dosen' => $dosen
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit(Dosen $dosen)
    {
        return view('v_dosen.edit', [
            'title' => 'Edit Data Dosen',
            'dosen' => $dosen
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nomor_induk' => 'required',
            'jabatan' => 'required',
            'jurusan' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $dosen->user->email) {
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

            if ($lama == $dosen->user->password) {
                if ($baru == $konfir) {
                    $user = User::create([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                        'nomor_induk' => $validatedData['nomor_induk'],
                        'nama' => $validatedData['nama'],
                        'role' => 'dosen'
                    ]);
                } else {
                    return redirect('/dosen/' . $dosen->id . '/edit')->with('fail', 'Konfirmasi Password harus sama dengan Password');
                }
            } else {
                return redirect('/dosen/' . $dosen->id . '/edit')->with('fail', 'Password Salah');
            }
        }

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('dosen-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'nama' => $validatedData['nama'],
            'role' => 'dosen'
        ]);

        unset($validatedData['email']);
        unset($validatedData['lama']);
        unset($validatedData['baru']);
        unset($validatedData['konfir']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        Dosen::create($validatedData);
        return redirect('/dosen')->with('success', 'Tambah Data Dosen Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        if ($dosen->foto) {
            Storage::delete($dosen->foto);
        }

        Dosen::destroy($dosen->id);
        User::destroy($dosen->user->id);
        return redirect('/dosen')->with('success', 'Data Dosen telah dihapus');
    }
}
