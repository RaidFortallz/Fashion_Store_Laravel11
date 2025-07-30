<?php

namespace App\Livewire\Admin\Category;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shop\Models\Category;

class CategoryIndex extends Component
{
    public $perPage = 5;

    #[Url(as: 'q')]
    public ? string $search;

    #[On('category-created')]
    #[On('category-updated')]
    public function render()
    {
        $categories = Category::orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $categories = $categories->where('name', 'LIKE', '%' . $this->search . '%');
        }

        return view('livewire.admin.category.category-index', [
            'categories' => $categories->paginate($this->perPage),
        ]);
    }

    public function delete($id) {
        $category = Category::findOrFail($id);
        $category->products()->detach();
        $category->delete();

        session()->flash('success', 'Kategori dihapus!');
    }

    public function changePerPage($perPage) {
        if (($perPage < 5) || ($perPage > 25)) {
            $this->perPage = 5;
            return;
        }

        $this->perPage = $perPage;
    }

}
