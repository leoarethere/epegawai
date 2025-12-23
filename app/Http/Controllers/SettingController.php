<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function updateBackground(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('background_image')) {
            // Hapus gambar lama jika ada (opsional, untuk hemat storage)
            $oldBg = Setting::where('key', 'login_background')->value('value');
            if ($oldBg && Storage::disk('public')->exists($oldBg)) {
                Storage::disk('public')->delete($oldBg);
            }

            // 1. Simpan file ke folder public/storage/settings
            $path = $request->file('background_image')->store('settings', 'public');

            // 2. Simpan path-nya ke database
            // Kita pakai 'updateOrCreate' agar jika data belum ada dia buat baru, kalau ada dia update
            Setting::updateOrCreate(
                ['key' => 'login_background'],
                ['value' => $path]
            );

            return back()->with('success', 'Foto background berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal mengupload gambar.');
    }

    // FUNGSI BARU UNTUK UPDATE LOGO (Langkah 2)
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo_image' => 'required|image|mimes:png,jpg,jpeg|max:1024', // Max 1MB
        ]);

        if ($request->hasFile('logo_image')) {
            // Hapus logo lama jika ada agar tidak menumpuk sampah file
            $oldLogo = Setting::where('key', 'login_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Simpan logo baru
            $path = $request->file('logo_image')->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => 'login_logo'],
                ['value' => $path]
            );

            return back()->with('success', 'Logo instansi berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal mengupload logo.');
    }
}