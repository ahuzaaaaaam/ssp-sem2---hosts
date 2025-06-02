<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;
    
    protected $listeners = ['editProduct' => 'edit'];
    
    public $name;
    public $description;
    public $price;
    public $image_url;
    public $image; // For file uploads
    public $veg = 'No';
    public $featured = 'No';
    
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $editMode = false;
    public $productId;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image_url' => 'nullable|url',
        'image' => 'nullable|image|max:1024', // 1MB Max
        'veg' => 'required|in:Yes,No',
        'featured' => 'required|in:Yes,No',
    ];
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function openModal()
    {
        $this->resetValidation();
        $this->resetExcept(['search', 'sortField', 'sortDirection']);
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->editMode = false;
    }
    
    public function create()
    {
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'veg' => $this->veg,
            'featured' => $this->featured,
        ];
        
        // Handle image upload if provided
        if ($this->image) {
            $filename = Str::slug($this->name) . '-' . time() . '.' . $this->image->extension();
            $path = $this->image->storeAs('public/products', $filename);
            $data['image_url'] = Storage::url($path);
        } else {
            $data['image_url'] = $this->image_url;
        }
        
        Product::create($data);
        
        $this->closeModal();
        $this->dispatch('product-saved');
        session()->flash('success', 'Product created successfully.');
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->image_url = $product->image_url;
        $this->veg = $product->veg;
        $this->featured = $product->featured;
        
        $this->editMode = true;
        $this->showModal = true;
    }
    
    public function update()
    {
        $this->validate();
        
        $product = Product::findOrFail($this->productId);
        
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'veg' => $this->veg,
            'featured' => $this->featured,
        ];
        
        // Handle image upload if provided
        if ($this->image) {
            $filename = Str::slug($this->name) . '-' . time() . '.' . $this->image->extension();
            $path = $this->image->storeAs('public/products', $filename);
            $data['image_url'] = Storage::url($path);
        } else {
            $data['image_url'] = $this->image_url;
        }
        
        $product->update($data);
        
        $this->closeModal();
        $this->dispatch('product-updated');
        session()->flash('success', 'Product updated successfully.');
    }
    
    public function confirmDelete($id)
    {
        $this->productId = $id;
        $this->dispatch('confirm-delete');
    }
    
    public function delete()
    {
        $product = Product::findOrFail($this->productId);
        $product->delete();
        
        $this->dispatch('product-deleted');
        session()->flash('success', 'Product deleted successfully.');
    }
    
    public function mount()
    {
        // Check if there's an edit parameter in the URL
        if (request()->has('edit')) {
            $productId = request()->get('edit');
            $this->edit($productId);
        }
    }
    
    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(8);
        
        return view('livewire.admin.product-manager', compact('products'));
    }
}
