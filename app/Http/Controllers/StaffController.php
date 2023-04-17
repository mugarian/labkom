<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = staff::orderBy('id', 'asc')->paginate(5);
        return view('v_staff.index', [
            'title' => 'Kelola Data staff',
            'staffs' => $staff
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_staff.create', [
            'title' => 'Tambah Data staff',
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
            'bidang' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('user-images');
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
            'role' => 'staff'
        ]);

        unset($validatedData['foto']);
        unset($validatedData['email']);
        unset($validatedData['password']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        staff::create($validatedData);
        return redirect('/staff')->with('success', 'Tambah Data staff Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        return view('v_staff.show', [
            'title' => $staff->user->nama,
            'staff' => $staff
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('v_staff.edit', [
            'title' => 'Edit Data staff',
            'staff' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'bidang' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $staff->user->email) {
            $validatedData['email'] = $request->validate(['email' => 'required|email:dns|unique:users']);
        } else {
            $validatedData['email'] = $request->validate(['email' => 'required']);
        }

        if ($request->nomor_induk != $staff->user->nomor_induk) {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required|unique:users']);
        } else {
            $validatedData['nomor_induk'] = $request->validate(['nomor_induk' => 'required']);
        }

        if ($request->password) {
            if (!Hash::check($request->password, $staff->user->password)) {
                return back()->with('password', 'The password field is incorrect');
            }
            $validatedData['new_password'] = $request->validate(['new_password' => 'required']);
            $validatedData['new_password_confirmation'] = $request->validate(['new_password_confirmation' => 'required|same:new_password']);
            $password = Hash::make($request->new_password);
        } else {
            $password = $staff->user->password;
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

        User::find($staff->user->id)->update([
            'email' => $request->email,
            'password' => $password,
            'nomor_induk' => $request->nomor_induk,
            'nama' => $request->nama,
            'foto' => $validatedData['foto'],
            'role' => 'staff'
        ]);

        unset($validatedData['foto']);
        unset($validatedData['email']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $staff->user->id;

        staff::find($staff->id)->update($validatedData);
        return redirect('/staff')->with('success', 'Ubah Data staff Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        if ($staff->foto) {
            Storage::delete($staff->foto);
        }

        staff::destroy($staff->id);
        User::destroy($staff->user->id);
        return redirect('/staff')->with('success', 'Data staff telah dihapus');
    }
}
