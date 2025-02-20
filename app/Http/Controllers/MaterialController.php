<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Material;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function show($id)
    {
        $material = Material::with('attachments')->findOrFail($id);

        $attachment = $material->attachments->first();

        if ($attachment) {
            $filePath = $attachment->file_path;
        } else {
            $filePath = null;
        }

        return view('post_detail', [
            'material' => $material,
            'filePath' => $filePath
        ]);
    }

    public function create($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        return view('material_post', compact('classroom'));
    }

    public function store(Request $request, $classroom_id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,pptx,jpeg,jpg,png|max:10240',
        ]);

        // Menyimpan materi
        $material = Material::create([
            'classroom_id' => $classroom_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // dd($request->all());
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('attachments', 'public');

            Attachment::create([
                'material_id' => $material->id,
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('classroom.show', $classroom_id)
            ->with('success', 'Materi berhasil diposting!');
    }

    public function download($id)
    {
        $material = Material::findOrFail($id);
        $filePath = $material->attachments->file_path;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return abort(404, 'File tidak ditemukan');
    }

    public function edit($classroom_id, $id)
    {
       $classroom = Classroom::findOrFail($classroom_id);
       $material = Material::with('attachments')->findOrFail($id);

       $attachment = $material->attachments->first();
       if ($attachment) {
            $filePath = $attachment->file_path;
        } else {
            $filePath = null;
        }

       return view('material_edit', [
        'classroom' => $classroom,
        'material' => $material,
        'filePath' => $filePath
       ]);
    }

    public function update(Request $request, $classroom_id, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,pptx,jpeg,jpg,png|max:10240',
        ]);

        // Cari materi berdasarkan ID
        $material = Material::findOrFail($id);
        $material->update($validated);

        // Jika ada file yang diunggah
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('attachments', 'public');

            // Cek apakah materi sudah memiliki attachment
            $attachment = $material->attachments()->first();

            if ($attachment) {
                // Update attachment yang sudah ada
                $attachment->update(['file_path' => $filePath]);
            } else {
                // Buat attachment baru jika belum ada
                $material->attachments()->create(['file_path' => $filePath]);
            }
        }

        return redirect()->route('classroom.show', $classroom_id)
            ->with('success', 'Materi berhasil diperbarui!');
    }


    public function destroy($classroom_id, $id)
    {
        $material = Material::findOrFail($id);

        // Hapus lampiran jika ada
        foreach ($material->attachments as $attachment) {
            Storage::delete('public/' . $attachment->file_path); // Hapus file dari storage
            $attachment->delete(); // Hapus data dari database
        }

        // Hapus materi
        $material->delete();

        return redirect()->route('classroom.show', $classroom_id)
            ->with('success', 'Materi berhasil dihapus!');
    }


}