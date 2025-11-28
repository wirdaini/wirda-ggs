<?php
namespace App\Http\Controllers;

use App\Models\Multipleuploads;
use Illuminate\Http\Request;

class MultipleuploadsController extends Controller
{
    public function index()
    {
        return view('multipleuploads');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'filename' => 'required',
    //         'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:2000',
    //         'ref_table' => 'required|string', // ✅ MODIFIKASI
    //         'ref_id' => 'required|integer' // ✅ MODIFIKASI
    //     ]);

    //     if ($request->hasfile('filename')) {
    //         $files = [];
    //         foreach ($request->file('filename') as $file) {
    //             if ($file->isValid()) {
    //                 $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
    //                 $file->move(public_path('images'), $filename);

    //                 // ✅ MODIFIKASI: Tambah ref_table dan ref_id
    //                 $files[] = [
    //                     'filename' => $filename,
    //                     'ref_table' => $request->ref_table,
    //                     'ref_id' => $request->ref_id,
    //                     'created_at' => now(),
    //                     'updated_at' => now()
    //                 ];
    //             }
    //         }
    //         Multipleuploads::insert($files);

    //         return back()->with('success', count($files) . ' file berhasil diupload!');
    //     }else{
    //         return back()->with('error', 'Gagal upload file!');
    //     }
    // }

    public function store(Request $request)
    {
        \Log::info('=== UPLOAD ATTEMPT ===');
        \Log::info('Request data:', $request->all());
        \Log::info('Files:', $request->file() ? ['exists' => true] : ['exists' => false]);

        try {
            // Validasi sederhana
            $request->validate([
                'filename'  => 'required',
                'ref_table' => 'required',
                'ref_id'    => 'required',
            ]);

            \Log::info('✅ Validation passed');

            if ($request->hasfile('filename')) {
                $files = [];
                foreach ($request->file('filename') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);

                    $files[] = [
                        'filename'   => $filename,
                        'ref_table'  => $request->ref_table,
                        'ref_id'     => $request->ref_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    \Log::info('📁 File saved: ' . $filename);
                }

                // Insert ke tabel multiuploads
                \App\Models\Multipleuploads::insert($files);
                \Log::info('💾 Database records created: ' . count($files));

                return back()->with('success', count($files) . ' file berhasil diupload!');
            } else {
                \Log::warning('❌ No files in request');
                return back()->with('error', 'Tidak ada file yang dipilih!');
            }

        } catch (\Exception $e) {
            \Log::error('🔥 ERROR: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ✅ MODIFIKASI: Tambah method destroy untuk hapus file
    public function destroy($id)
    {
        try {
            $file = Multipleuploads::findOrFail($id);

            // Delete file dari folder
            if (file_exists(public_path('images/' . $file->filename))) {
                unlink(public_path('images/' . $file->filename));
            }

            $file->delete();

            return back()->with('success', 'File berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }
}
