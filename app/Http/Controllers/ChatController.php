<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function adminIndex()
    {
        // Ambil semua request yang sudah accepted/chatting/finished
        $requests = RequestModel::with(['murid', 'guru'])
            ->whereIn('status', ['accepted', 'chatting', 'finished'])
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.chats.index', compact('requests'));
    }

    public function adminShow($requestId)
    {
        $requestModel = RequestModel::with(['murid', 'guru'])->findOrFail($requestId);
        $chats = Chat::where('request_id', $requestId)->orderBy('created_at', 'asc')->get();

        return view('admin.chats.show', compact('requestModel', 'chats'));
    }

    // Menampilkan halaman chat untuk request tertentu
    public function show($requestId)
    {
        $requestModel = RequestModel::findOrFail($requestId);
        $user = Auth::user();

        if (!in_array($user->id, [$requestModel->murid_id, $requestModel->guru_id])) {
            abort(403, 'Anda tidak berhak mengakses chat ini.');
        }

        // Perbolehkan buka chat jika status 'accepted', 'chatting', atau 'finished'
        if (!in_array($requestModel->status, ['accepted', 'chatting', 'finished'])) {
            abort(403, 'Chat hanya tersedia jika status diterima, sedang chatting, atau telah selesai.');
        }

        // Hanya update ke 'chatting' jika sebelumnya 'accepted'
        if ($requestModel->status === 'accepted') {
            $requestModel->update(['status' => 'chatting']);
        }

        $chats = Chat::where('request_id', $requestId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('requestModel', 'chats'));
    }
    // Menyimpan pesan chat baru
    public function send(Request $request, $requestId)
    {
        $requestModel = RequestModel::findOrFail($requestId);
        $user = Auth::user();

        // Pastikan user pihak terkait
        if (!in_array($user->id, [$requestModel->murid_id, $requestModel->guru_id])) {
            abort(403, 'Anda tidak berhak mengirim pesan pada chat ini.');
        }

        // Hanya bisa kirim pesan jika status 'chatting'
        if ($requestModel->status !== 'chatting') {
            abort(403, 'Chat hanya tersedia saat proses chatting.');
        }

        // Validasi pesan
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Simpan pesan chat
        Chat::create([
            'request_id' => $requestId,
            'sender_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return redirect()->route('chat.show', $requestId)->with('success', 'Pesan terkirim!');
    }

    public function end($requestId)
    {
        $requestModel = RequestModel::findOrFail($requestId);
        $user = Auth::user();

        // Pastikan user adalah murid/guru terkait
        if (!in_array($user->id, [$requestModel->murid_id, $requestModel->guru_id])) {
            abort(403, 'Anda tidak berhak mengakhiri chat ini.');
        }

        // Hanya bisa end chat jika status chatting
        if ($requestModel->status !== 'chatting') {
            return redirect()->back()->with('error', 'Percakapan sudah selesai atau belum dimulai.');
        }

        $requestModel->update(['status' => 'finished']);

        return redirect()->route('requests.index', $requestId)->with('success', 'Percakapan telah diakhiri.');
    }
}
