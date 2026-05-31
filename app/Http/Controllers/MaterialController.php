<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'type' => 'required|in:pdf,video,modul,link',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,png,jpg,jpeg|max:20480',
            'url' => 'nullable|url|max:500',
        ]);

        // Minimal salah satu file atau URL harus ada
        if (!$request->hasFile('file') && !$request->filled('url')) {
            return back()
                ->withErrors(['file' => 'Upload file atau masukkan URL materi terlebih dahulu.'])
                ->withInput();
        }

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('materials', 'public');
        }

        Material::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'topic' => $request->topic,
            'type' => $request->type,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName ?? $request->title,
            'url' => $request->url,
        ]);

        return redirect()->route('eksplor.topik')
            ->with('success', 'Materi berhasil diupload! 🎉');
    }

    public function destroy(Material $material)
    {
        if ($material->user_id !== auth()->id()) {
            abort(403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
