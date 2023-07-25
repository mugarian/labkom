<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function getLogin(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => '99bb78db-c176-4314-8122-08f35fdb5c34',
            'redirect_uri' => 'https://simalakom.elearningpolsub.com/callback',
            'response_type' => 'code',
            'scope' => 'view-user',
            'state' => $state,
            'prompt' => '', // "none", "consent", or "login"
        ]);

        return redirect('https://sso.elearningpolsub.com/oauth/authorize?' . $query);
    }

    public function getCallback(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $response = Http::asForm()->post(
            'https://sso.elearningpolsub.com/oauth/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => '99bb78db-c176-4314-8122-08f35fdb5c34',
                'client_secret' => 'CtNR6V3DlM1xQT6lgsKDWv7jiFgZWcJ5whpf2PBO',
                'redirect_uri' => 'https://simalakom.elearningpolsub.com/callback',
                'code' => $request->code,
            ]
        );

        $request->session()->put($response->json());
        return redirect(route('sso.connect'));
    }

    public function connectUser(Request $request)
    {
        $access_token = $request->session()->get("access_token");
        $response = Http::withHeaders([
            "Accept" => "Application/Json",
            "Authorization" => "Bearer " . $access_token
        ])->get("https://sso.elearningpolsub.com/api/user");

        $userArray = $response->json();
        try {
            $email = $userArray['email'];
        } catch (\Throwable $th) {
            return redirect('login')->withErrors('Failed to get login information! Try Again!');
        }
        User::upsert([
            'nomor_induk' => $userArray['no_induk'],
            'nama' => $userArray['name'],
            'role' => $userArray['role'],
            'email' => $userArray['email'],
            'password' => Hash::make($userArray['no_induk']),
        ], ['email', 'nomor_induk']);

        $user = User::where('email', $email)->first();

        switch ($user->role) {
            case 'dosen':
                Dosen::upsert([
                    'user_id' => $user->id,
                    'jabatan' => 'dosen pengampu',
                    'kepalalab' => 'false',
                    'jurusan' => $userArray['major'],
                ], ['user_id']);
                break;
            case 'mahasiswa':
                Mahasiswa::upsert([
                    'user_id' => $user->id,
                    'kelas_id' => null,
                    'angkatan' => '2020',
                    'jurusan' => $userArray['major'],
                ], ['user_id']);
                break;
            default:
                # code...
                break;
        }

        Auth::login($user);
        return redirect('/dashboard');
    }
}
