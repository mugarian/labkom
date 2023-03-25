<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
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
        $staff = staff::all();
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
            'nomor_induk' => 'required',
            'bidang' => 'required',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'konfir' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($validatedData['password'] == $validatedData['konfir']) {
            if ($request->file('upload')) {
                $validatedData['upload'] = $request->file('upload')->store('staff-images');
            }

            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'nomor_induk' => $validatedData['nomor_induk'],
                'nama' => $validatedData['nama'],
                'role' => 'staff'
            ]);
        } else {
            return redirect('/staff/create')->with('fail', 'Konfirmasi Password harus sama dengan Password');
        }

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
            'nomor_induk' => 'required',
            'angkatan' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->email != $staff->user->email) {
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

            if ($lama == $staff->user->password) {
                if ($baru == $konfir) {
                    $user = User::create([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                        'nomor_induk' => $validatedData['nomor_induk'],
                        'nama' => $validatedData['nama'],
                        'role' => 'staff'
                    ]);
                } else {
                    return redirect('/staff/' . $staff->id . '/edit')->with('fail', 'Konfirmasi Password harus sama dengan Password');
                }
            } else {
                return redirect('/staff/' . $staff->id . '/edit')->with('fail', 'Password Salah');
            }
        }

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('staff-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'nama' => $validatedData['nama'],
            'role' => 'staff'
        ]);

        unset($validatedData['email']);
        unset($validatedData['lama']);
        unset($validatedData['baru']);
        unset($validatedData['konfir']);
        unset($validatedData['nomor_induk']);
        unset($validatedData['nama']);

        $validatedData['user_id'] = $user->id;

        staff::create($validatedData);
        return redirect('/staff')->with('success', 'Tambah Data staff Berhasil');
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
