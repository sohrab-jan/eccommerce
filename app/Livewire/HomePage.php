<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

class HomePage extends Component
{
    #[Title('Home')]


    public function render()
    {
        return view('livewire.home-page', [
            'categories' => Category::where('is_active',true)->get(),
            'brands' => Brand::where('is_active',true)->get(),
        ]);
    }
}
