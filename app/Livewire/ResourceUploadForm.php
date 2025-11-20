<?php

namespace App\Livewire;

use App\Models\Resource;
use App\Models\Category;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResourceUploadForm extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $installation_instructions;
    public $category_id;
    public $tags = [];
    public $resource_file;
    public $version = '1.0';

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'description' => 'required|min:10',
        'category_id' => 'required|exists:categories,id',
        'resource_file' => 'required|file|max:102400', // 100MB max
        'version' => 'required',
    ];

    public function save()
    {
        $this->validate();

        try {
            $fileService = app(FileService::class);
            
            // Process file upload
            $fileData = $fileService->handleUpload($this->resource_file, $this->category_id);

            // Create resource
            $resource = Resource::create([
                'title' => $this->title,
                'slug' => \Str::slug($this->title),
                'description' => $this->description,
                'installation_instructions' => $this->installation_instructions,
                'user_id' => Auth::id(),
                'category_id' => $this->category_id,
                'file_path' => $fileData['path'],
                'file_size' => $fileData['size'],
                'file_type' => $fileData['type'],
                'version' => $this->version,
                'is_approved' => Auth::user()->isModerator(), // Auto-approve for moderators
            ]);

            // Handle tags
            if (!empty($this->tags)) {
                $resource->tags()->attach($this->tags);
            }

            session()->flash('success', 'Resource uploaded successfully! ' . 
                (Auth::user()->isModerator() ? 'It is now live.' : 'Waiting for moderator approval.'));

            return redirect()->route('resources.show', $resource);

        } catch (\Exception $e) {
            session()->flash('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.resource-upload-form', [
            'categories' => Category::all(),
        ]);
    }
}