<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSearch extends Component
{
    public $search = '';
    public $category = '';
    public $priceRange = '';
    public $dietaryFilter = 'all'; // Options: 'all', 'veg', 'nonveg'
    
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'priceRange' => ['except' => ''],
        'dietaryFilter' => ['except' => 'all'],
    ];
    
    public function resetFilters()
    {
        $this->reset(['search', 'category', 'priceRange']);
        $this->dietaryFilter = 'all';
    }
    
    // This method is automatically called when any property changes
    public function render()
    {
        $query = Product::query();
        
        // Search functionality
        if ($this->search && strlen($this->search) > 0) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }
        
        // Category filter temporarily disabled as the column doesn't exist
        // if ($this->category) {
        //     $query->where('category', $this->category);
        // }
        
        if ($this->dietaryFilter === 'veg') {
            $query->where('veg', 'Yes');
        } elseif ($this->dietaryFilter === 'nonveg') {
            $query->where('veg', 'No');
        }
        
        if ($this->priceRange) {
            [$min, $max] = explode('-', $this->priceRange);
            $query->whereBetween('price', [$min, $max]);
        }
        
        $products = $query->latest()->paginate(12);
        
        return view('livewire.product-search', [
            'products' => $products,
            'categories' => ['Pizza', 'Sides', 'Drinks'], // Temporary hardcoded categories
        ]);
    }
}
