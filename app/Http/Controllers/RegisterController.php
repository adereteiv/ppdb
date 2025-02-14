<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InfoAnak;
use App\Models\Pendaftaran;
use App\Models\BatchPPDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister(){
        $activeBatch = BatchPPDB::where('status', true)->first();

        if (!$activeBatch) {
            return view('daftar', ['batchClosed' => true]);
        }

        return view('daftar', ['batchClosed' => false]);
    }

    public function store(Request $request){
        /*test purpose
        return response()->json(request()->all());
        */

        //Untuk mendapatkan batch_id
        $activeBatch = BatchPPDB::where('status', true)->first();

        //Cek pasangan email dan anak
        $existingUser = User::where('email', $request->email)->first();
        $existingChild = InfoAnak::where('nama_anak', $request->nama_anak)
            ->whereHas('pendaftaran', function($query) use ($existingUser) {
                $query->where('user_id', optional($existingUser)->id);
            })->exists();
        if ($existingUser && $existingChild) {
            return back()->with('email' , 'Anak dengan email ini telah didaftarkan.')->withInput();
        }

        /*test purpose
        $validated = $request->validate([
        */
        $request->validate([
            'email'=> 'required|email:rfc,dns',
            'password' => 'required|min:8|max:255',
            'password2' => 'required|same:password',
            'nama_anak' => 'required|string|max:255',
            'panggilan_anak' => 'required|string|max:255',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => [
                'required','date',
                'before_or_equal:' . now()->toDateString(), // Ensure no future dates
                'before_or_equal:' . now()->subYears(3)->toDateString() // Ensure at least 3 years ago
            ],
            'alamat_anak' => 'required|string',
        ]);

        /*test purpose
        dd('Ok');
        dd($validated);
        */

        $user = User::create([
            'name' => $request->nama_anak,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $pendaftaran = Pendaftaran::create([
            'user_id' => $user->id,
            'batch_id' => $activeBatch->id,
        ]);

        InfoAnak::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anak' => $request->nama_anak,
            'panggilan_anak' => $request->panggilan_anak,
            'tempat_lahir'=> $request->tempat_lahir,
            'tanggal_lahir'=> $request->tanggal_lahir,
            'alamat_anak'=> $request->alamat_anak,
        ]);

        // Kirim email dengan ID Pengguna

        return redirect('/login')->with('berhasil', 'Registrasi akun berhasil! Silakan login.');
    }
}
