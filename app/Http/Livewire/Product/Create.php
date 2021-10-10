<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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
        'image' => 'image|max:1024'
    ];

    public function store()
    {
        $this->validate();

        $imageName = '';

        if ($this->image) {
            $imageName = Str::slug($this->title, '-')
                . '-'
                . uniqId()
                . '.' . $this->image->getClientOriginalExtension();

            $this->image->storeAs('public', $imageName, 'local');

            // $this->image = $imageName;
        }

        Product::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imageName,
        ]);

        $this->emit('productStored');
    }
}
