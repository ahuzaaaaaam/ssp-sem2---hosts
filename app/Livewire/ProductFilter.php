<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductFilter extends Component
{
    public $filter = 'all';
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    protected $queryString = [
        'filter' => ['except' => 'all'],
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilter()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function render()
    {
        $query = Product::query();
        
        // Apply category filter
        if ($this->filter === 'veg') {
            $query->where('veg', 'Yes');
        } elseif ($this->filter === 'non-veg') {
            $query->where('veg', 'No');
        } elseif ($this->filter === 'featured') {
            $query->where('featured', 'Yes');
        }
        
        // Apply search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);
        
        $products = $query->get();
        
        return view('livewire.product-filter', [
            'products' => $products,
        ]);
    }
}
