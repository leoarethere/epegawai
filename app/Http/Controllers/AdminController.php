<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $listBagian = User::where('role', 'pegawai')->whereNotNull('bagian')->where('bagian', '!=', '')->distinct()->pluck('bagian')->sort();
        $query = User::where('role', 'pegawai');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('filter_bagian') && $request->filter_bagian != '') {
            $query->where('bagian', $request->filter_bagian);
        }

        $pegawai = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.dashboard', compact('pegawai', 'listBagian'));
    }

    public function create()
    {
        return view('admin.create'); 
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_lengkap'   => 'required|string|max:150',
            'nik'            => 'required|numeric|digits:16|unique:users,nik',
            'nip'            => 'nullable|numeric|digits:18|unique:users,nip',
            'email'          => 'required|email|unique:users,email',
            'status_pegawai' => 'required|in:CPNS,PNS,PPPK,KONTRAK',
            'status_operasional' => 'required|in:Aktif,Non-Aktif',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'telepon'        => 'required|numeric',
            'foto_profil'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            
            // Validasi Dokumen (Format URL)
            'doc_ktp' => 'nullable|url',
            'doc_kk' => 'nullable|url',
            'doc_npwp' => 'nullable|url',
            'doc_akta_nikah' => 'nullable|url',
            'doc_akta_anak_folder' => 'nullable|url',
            'doc_folder_ijazah' => 'nullable|url',
            'doc_jenis_sk' => 'nullable|in:SK CPNS,SK PNS,SK PPPK,SK KONTRAK',
            'doc_link_sk' => 'nullable|url',
            'doc_sk_naik_pangkat' => 'nullable|url',
            'doc_sertifikat_diklat' => 'nullable|url',
            'doc_file_pendukung' => 'nullable|url',
        ], [
            'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'nip.digits' => 'NIP harus berjumlah tepat 18 digit.',
            'nip.unique' => 'NIP ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'telepon.numeric' => 'Nomor telepon harus berupa angka.',
            'foto_profil.image' => 'File harus berupa gambar (jpg/png).',
            'status_pegawai.required' => 'Status pegawai harus dipilih.',
            'status_pegawai.in' => 'Status pegawai tidak valid.',
            'status_operasional.required' => 'Status operasional harus dipilih.',
            '*.url' => 'Format link dokumen harus berupa URL valid (https://...).',
        ]);

        // Upload Foto
        $pathFoto = null;
        if ($request->hasFile('foto_profil')) {
            $pathFoto = $request->file('foto_profil')->store('profil', 'public');
        }

        // Default Password = NIK
        $defaultPassword = $request->nik; 

        // Simpan Data
        User::create([
            'nama_lengkap'   => $request->nama_lengkap,
            'nik'            => $request->nik,
            'nip'            => $request->nip,
            'email'          => $request->email,
            'password'       => Hash::make($defaultPassword),
            'role'           => 'pegawai',
            'foto_profil'    => $pathFoto,
            'status_pegawai' => $request->status_pegawai,
            'jabatan'        => $request->jabatan,
            'bagian'         => $request->bagian,
            'status_operasional' => $request->status_operasional,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'agama'          => $request->agama,
            'telepon'        => $request->telepon,
            'alamat_ktp'     => $request->alamat_ktp,
            
            // DOKUMEN
            'doc_ktp'             => $request->doc_ktp,
            'doc_kk'              => $request->doc_kk,
            'doc_npwp'            => $request->doc_npwp,
            'doc_akta_nikah'      => $request->doc_akta_nikah,
            'doc_akta_anak_folder'=> $request->doc_akta_anak_folder, 
            
            'doc_jenis_sk'        => $request->doc_jenis_sk,
            'doc_link_sk'         => $request->doc_link_sk,
            'doc_sk_naik_pangkat' => $request->doc_sk_naik_pangkat,

            'doc_folder_ijazah'   => $request->doc_folder_ijazah,
            'doc_sertifikat_diklat' => $request->doc_sertifikat_diklat,
            'doc_file_pendukung'    => $request->doc_file_pendukung,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Pegawai berhasil ditambahkan! Password default adalah NIK pegawai.');
    }

    public function show($id)
    {
        $pegawai = User::findOrFail($id); 
        return view('admin.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = User::findOrFail($id);
        return view('admin.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'nik'          => 'required|numeric|digits:16|unique:users,nik,'.$pegawai->id,
            'nip'          => 'nullable|numeric|digits:18|unique:users,nip,'.$pegawai->id,
            'email'        => 'required|email|unique:users,email,'.$pegawai->id,
            'status_pegawai' => 'required|in:CPNS,PNS,PPPK,KONTRAK',
            'status_operasional' => 'required|in:Aktif,Non-Aktif',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'telepon'      => 'required|numeric',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'     => 'nullable|numeric|min:6',
            
            // Validasi Dokumen
            'doc_ktp' => 'nullable|url',
            'doc_kk' => 'nullable|url',
            'doc_npwp' => 'nullable|url',
            'doc_akta_nikah' => 'nullable|url',
            'doc_akta_anak_folder' => 'nullable|url',
            'doc_folder_ijazah' => 'nullable|url',
            'doc_jenis_sk' => 'nullable|in:SK CPNS,SK PNS,SK PPPK,SK KONTRAK',
            'doc_link_sk' => 'nullable|url',
            'doc_sk_naik_pangkat' => 'nullable|url',
            'doc_sertifikat_diklat' => 'nullable|url',
            'doc_file_pendukung' => 'nullable|url',
        ], [
            'password.numeric' => 'Password harus berupa angka (PIN).',
            'password.min' => 'Password minimal 6 digit.',
        ]);

        $dataUpdate = [
            'nama_lengkap'   => $request->nama_lengkap,
            'nik'            => $request->nik,
            'nip'            => $request->nip,
            'email'          => $request->email,
            'status_pegawai' => $request->status_pegawai,
            'jabatan'        => $request->jabatan,
            'bagian'         => $request->bagian,
            'status_operasional' => $request->status_operasional,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'agama'          => $request->agama,
            'telepon'        => $request->telepon,
            'alamat_ktp'     => $request->alamat_ktp,
            
            // UPDATE DOKUMEN
            'doc_ktp'             => $request->doc_ktp,
            'doc_kk'              => $request->doc_kk,
            'doc_npwp'            => $request->doc_npwp,
            'doc_akta_nikah'      => $request->doc_akta_nikah,
            'doc_akta_anak_folder'=> $request->doc_akta_anak_folder, 
            
            'doc_folder_ijazah'   => $request->doc_folder_ijazah,
            'doc_jenis_sk'        => $request->doc_jenis_sk,
            'doc_link_sk'         => $request->doc_link_sk,
            'doc_sk_naik_pangkat' => $request->doc_sk_naik_pangkat,

            'doc_sertifikat_diklat' => $request->doc_sertifikat_diklat,
            'doc_file_pendukung'    => $request->doc_file_pendukung,
        ];

        // Update Foto
        if ($request->hasFile('foto_profil')) {
            if ($pegawai->foto_profil && Storage::disk('public')->exists($pegawai->foto_profil)) {
                Storage::disk('public')->delete($pegawai->foto_profil);
            }
            $dataUpdate['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        $pegawai->update($dataUpdate);

        // Update Password jika diisi
        if($request->filled('password')) {
            $pegawai->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);
        
        if ($pegawai->foto_profil && Storage::disk('public')->exists($pegawai->foto_profil)) {
            Storage::disk('public')->delete($pegawai->foto_profil);
        }

        $pegawai->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data pegawai berhasil dihapus!');
    }
}