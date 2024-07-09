<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoriesPage extends Component
{
    #[Title('Categories')]
    public function render()
    {
        return view('livewire.categories-page', [
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }
}
