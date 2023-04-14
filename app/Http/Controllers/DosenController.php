<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'nomor_induk' => 'required|unique:users',
            'jabatan' => 'required',
            'jurusan' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('dosen-images');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'nama' => $validatedData['nama'],
            'foto' => $validatedData['foto'],
            'role' => 'dosen'
        ]);

        unset($validatedData['foto']);
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
            'jabatan' => 'required',
            'jurusan' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $dosen->user->email) {
            $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:users']);
        } else {
            $validatedData['email'] = $request->validate(['email' => 'required']);
        }

        if ($request->nomor_induk != $dosen->user->nomor_induk) {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required|unique:users']);
        } else {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required']);
        }

        if ($request->password) {
            if (!Hash::check($request->password, $dosen->user->password)) {
                return back()->with('password', 'The password field is incorrect');
            }
            $validatedData['new_password'] = $request->validate(['new_password' => 'required']);
            $validatedData['new_password_confirmation'] = $request->validate(['new_password_confirmation' => 'required|same:new_password']);
            $password = Hash::make($request->new_password);
        } else {
            $password = $dosen->user->password;
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

        User::find($dosen->user->id)->update([
            'email' => $request->email,
            'password' => $password,
            'nomor_induk' => $request->nomor_induk,
            'nama' => $request->nama,
            'foto' => $validatedData['foto'],
            'role' => 'dosen'
        ]);

        unset($validatedData['foto']);
        unset($validatedData['email']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $dosen->user->id;

        Dosen::find($dosen->id)->update($validatedData);
        return redirect('/dosen')->with('success', 'Ubah Data Dosen Berhasil');
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
