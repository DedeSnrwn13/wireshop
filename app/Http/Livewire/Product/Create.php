<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $description;
    public $price;
    public $image;
    
    public function render()
    {
        return view('livewire.product.create');
    }

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|max:180',
        'price' => 'required|numeric',
    ];

    public function store()
    {
        $this->validate();

        Product::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        $this->emit('productStored');
    }
}
