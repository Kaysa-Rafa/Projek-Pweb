<?php
// app/Models/Resource.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'description',
        'file_path', 'original_filename', 'file_extension', 'file_mime_type',
        'file_size', 'version', 'download_count', 'view_count', 
        'is_approved', 'is_featured', 'is_public', 'update_notes'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'file_size' => 'integer',
    ];

    // ... relationships tetap sama ...

    // File related methods
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
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive',
            '7z' => 'fa-file-archive',
            'w3x' => 'fa-file-code',
            'w3m' => 'fa-file-code',
            'map' => 'fa-map',
            'jpg' => 'fa-file-image',
            'jpeg' => 'fa-file-image',
            'png' => 'fa-file-image',
            'gif' => 'fa-file-image',
            'pdf' => 'fa-file-pdf',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'txt' => 'fa-file-alt',
        ];

        return $icons[$extension] ?? 'fa-file';
    }

    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }

    public function getDownloadUrl()
    {
        return route('resources.download', $this);
    }
}