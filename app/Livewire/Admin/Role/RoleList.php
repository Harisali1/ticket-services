<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class RoleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'name' => '',
    ];

    public $perPage = 10;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Reset page when filters change
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function render()
    {
        $roles = Role::query()
            ->when($this->filters['name'], fn ($q) =>
                $q->where('name', 'like', '%' . $this->filters['name'] . '%')
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.role.role-list', compact('roles'));
    }
}
