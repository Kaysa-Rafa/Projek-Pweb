<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            
            // PERBAIKAN PENTING:
            // Mengganti 'mimes' menjadi 'extensions'.
            // Ini memecahkan masalah file W3X/MAP yang terdeteksi sebagai binary biasa.
            'resource_file' => [
                'required',
                'file',
                'max:51200', // 50MB
                'extensions:zip,rar,7z,w3x,w3m,map,jpg,jpeg,png,gif,pdf,doc,docx,txt,w3n'
            ],
            
            'version' => 'required|string|max:20',
            'installation_instructions' => 'nullable|string',
            'update_notes' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_public' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'resource_file.required' => 'File resource wajib diupload.',
            'resource_file.extensions' => 'Format file tidak didukung. Gunakan: ZIP, RAR, 7Z, W3X, W3M, MAP, Gambar, PDF, DOC, TXT, W3N.',
            'resource_file.max' => 'Ukuran file terlalu besar (Maksimal 50MB).',
            'category_id.required' => 'Kategori wajib dipilih.',
            'title.required' => 'Judul resource wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
        ];
    }
}