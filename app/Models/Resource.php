<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        // PENTING: user_id harus ada di sini agar bisa disimpan
        'user_id', 
        'category_id', 
        'title', 
        'slug', 
        'description',
        'file_path', 
        'original_filename', 
        'file_extension', 
        'file_mime_type',
        'file_size', 
        'version', 
        'download_count', 
        'view_count', 
        'is_approved', 
        'is_featured', 
        'is_public', 
        'update_notes'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'file_size' => 'integer',
    ];

    // Relasi User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Helper untuk format ukuran file
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getFileIconAttribute()
    {
        $extension = strtolower($this->file_extension);
        $icons = [
            'zip' => 'fa-file-archive', 'rar' => 'fa-file-archive', '7z' => 'fa-file-archive',
            'w3x' => 'fa-map', 'w3m' => 'fa-map', 'map' => 'fa-map',
            'jpg' => 'fa-file-image', 'png' => 'fa-file-image', 'pdf' => 'fa-file-pdf',
            'txt' => 'fa-file-alt'
        ];
        return $icons[$extension] ?? 'fa-file';
    }

    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }
}