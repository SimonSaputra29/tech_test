<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Request;
use App\Models\Schedule;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.index');
    }

    public function show()
    {
        $guru = Auth::user();
        return view('profile.guru.show', compact('guru'));
    }

    public function showForum($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $currentUser = auth()->user();

        // Contoh: murid dan admin boleh lihat profil guru
        if (!in_array($currentUser->role, ['murid', 'admin'])) {
            abort(403, "You don't have access to view this profile");
        }

        return view('profile.guru.show', compact('guru'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.guru.edit', compact('user'));
    }

    // Proses update profile
    public function update(HttpRequest $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'identity_card' => 'nullable|image|max:2048',
        ];

        if ($user->role === 'guru') {
            $rules['skill'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Upload photo profile jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        // Upload identity_card (KTP/kartu pelajar) jika ada
        if ($request->hasFile('identity_card')) {
            if ($user->identity_card) {
                Storage::disk('public')->delete($user->identity_card);
            }
            $path = $request->file('identity_card')->store('identity_cards', 'public');
            $validated['identity_card'] = $path;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }

    // ================= SCHEDULE SECTION ==================

    // Daftar seluruh request yang masuk ke guru
    public function requestIndex()
    {
        $guruId = auth()->id();

        // Pastikan relasi 'murid' sudah ada di model Request
        $requests = Request::where('guru_id', $guruId)->with('murid')->get();

        return view('guru.requests.index', compact('requests'));
    }

    // Daftar jadwal untuk satu request tertentu
    public function scheduleIndex($requestId)
    {
        $requestModel = Request::with('murid')->findOrFail($requestId);
        $schedules = Schedule::where('request_id', $requestId)
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('guru.requests.schedule-index', compact('requestModel', 'schedules'));
    }

    // Form tambah jadwal
    public function scheduleCreate($requestId)
    {
        $requestModel = Request::with('murid')->findOrFail($requestId);
        return view('guru.requests.schedule-create', compact('requestModel'));
    }

    // Simpan jadwal baru
    public function scheduleStore(HttpRequest $request, $requestId)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $requestModel = Request::findOrFail($requestId);

        Schedule::create([
            'request_id' => $requestModel->id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('guru.requests.schedule.index', $requestModel->id)
            ->with('success', 'Jadwal berhasil dibuat.');
    }

    // Hapus jadwal
    public function scheduleDestroy($requestId, $scheduleId)
    {
        $schedule = Schedule::where('request_id', $requestId)->findOrFail($scheduleId);
        $schedule->delete();

        return redirect()->route('guru.requests.schedule.index', $requestId)
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
