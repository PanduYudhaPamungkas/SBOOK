<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::get();
        return view('pemilik.fields.index', compact('fields'));
    }

    public function detailLapangan($lapanganId, $tanggal)
    {
        $lapangan = \App\Models\Field::findOrFail($lapanganId);

        $orders = \App\Models\Order::with('user', 'field')
            ->where('lapangan_id', $lapanganId)
            ->where('tanggal', $tanggal)
            ->where('status', 'confirmed')
            ->get()
            ->filter(function ($order) {
                $now = time(); // waktu sekarang (timestamp)

                // Ambil jam selesai dari "07:00 - 08:00"
                $jamParts = explode('-', $order->jam);
                $jamSelesai = isset($jamParts[1]) ? trim($jamParts[1]) : null;

                // Gabungkan tanggal + jam selesai jadi timestamp
                $waktuSelesai = strtotime($order->tanggal . ' ' . $jamSelesai);

                // Tampilkan hanya jika waktu selesai > sekarang
                return $waktuSelesai > $now;
            });

        return view('pemilik.fields.detail', compact('orders', 'lapangan', 'tanggal'));
    }




    public function create()
    {
        return view('pemilik.fields.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'price' => 'required|integer',
            'available' => 'required|boolean'
        ]);

        $data['available'] = $request->available;


        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }

        $data['user_id'] = auth()->id();
        Field::create($data);

        return redirect()->route('fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

        // Fungsi untuk menampilkan form edit
    public function edit($id)
    {
        $field = Field::findOrFail($id);

        return view('pemilik.fields.edit', compact('field'));
    }

    // Fungsi untuk menyimpan hasil update
    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);


        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'price' => 'required|integer',
            'available' => 'required|boolean'
        ]);

        if ($request->hasFile('photo')) {
            // Optional: hapus foto lama jika ada
            if ($field->photo && \Storage::disk('public')->exists($field->photo)) {
                \Storage::disk('public')->delete($field->photo);
            }

            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }

        $field->update($data);

        return redirect()->route('fields.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

}
