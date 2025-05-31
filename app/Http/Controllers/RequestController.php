<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    // Tampilkan daftar request untuk murid atau guru yang sedang login
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'murid') {
            $requests = RequestModel::where('murid_id', $user->id)->get();
            return view('murid.requests.index', compact('requests'));
        } elseif ($user->role === 'guru') {
            $requests = RequestModel::where('guru_id', $user->id)->get();
            return view('guru.requests.index', compact('requests'));
        } else {
            abort(403);
        }
    }

    // Form buat request (murid yang request ke guru)
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'murid') {
            abort(403);
        }

        $gurus = User::where('role', 'guru')->get();
        return view('murid.requests.create', compact('gurus'));
    }

    // Simpan request baru
    public function store(HttpRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'murid') {
            abort(403);
        }

        $request->validate([
            'guru_id' => 'required|exists:users,id',
        ]);

        RequestModel::create([
            'murid_id' => $user->id,
            'guru_id' => $request->guru_id,
            'status' => 'pending',
            'status_chat' => 'active', // jika pakai kolom ini
        ]);

        return redirect()->route('requests.index')->with('success', 'Request berhasil dibuat.');
    }

    // Terima request (guru)
    public function accept($id)
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403);
        }

        $requestModel = RequestModel::where('id', $id)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $requestModel->update(['status' => 'accepted']);

        return redirect()->route('requests.index')->with('success', 'Request diterima.');
    }

    // Tolak request (guru)
    public function reject($id)
    {
        $user = Auth::user();
        if ($user->role !== 'guru') {
            abort(403);
        }

        $requestModel = RequestModel::where('id', $id)
            ->where('guru_id', $user->id)
            ->firstOrFail();

        $requestModel->update(['status' => 'rejected']);

        return redirect()->route('requests.index')->with('success', 'Request ditolak.');
    }

    // Mulai chat: status berubah dari accepted ke chatting (tidak ada deal manual!)
    public function startChat($id)
    {
        $user = Auth::user();
        $requestModel = RequestModel::findOrFail($id);

        // Pastikan hanya pihak terkait
        if (!in_array($user->id, [$requestModel->murid_id, $requestModel->guru_id])) {
            abort(403);
        }

        // Jika status masih accepted, ubah ke chatting
        if ($requestModel->status === 'accepted') {
            $requestModel->update(['status' => 'chatting']);
        }

        // Selanjutnya arahkan ke halaman chat
        return redirect()->route('chat.show', $requestModel->id);
    }

    // Selesaikan (setelah chat)
    public function finish($id)
    {
        $user = Auth::user();
        $requestModel = RequestModel::findOrFail($id);

        if (!in_array($user->id, [$requestModel->murid_id, $requestModel->guru_id])) {
            abort(403);
        }

        // Hanya bisa selesai dari status chatting
        if ($requestModel->status !== 'chatting') {
            abort(403, 'Belum bisa diselesaikan');
        }

        $requestModel->update(['status' => 'finished', 'status_chat' => 'finished']);

        return redirect()->route('requests.index')->with('success', 'Percakapan telah diakhiri.');
    }
}
