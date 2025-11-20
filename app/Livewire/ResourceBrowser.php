<?php

namespace App\Livewire;

use App\Models\Resource;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ResourceBrowser extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'latest';
    public $perPage = 20;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sortBy' => ['except' => 'latest']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Resource::approved()->with(['user', 'category', 'tags']);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'popular':
                $query->orderBy('download_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $resources = $query->paginate($this->perPage);
        $categories = Category::all();

        return view('livewire.resource-browser', [
            'resources' => $resources,
            'categories' => $categories,
        ]);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->sortBy = 'latest';
        $this->resetPage();
    }
}