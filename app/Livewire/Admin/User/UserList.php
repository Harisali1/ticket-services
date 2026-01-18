<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'name' => '',
        'email' => '',
        'status' => '',
        'from' => '',
        'to' => '',
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
        $users = User::query()->where('user_type_id', '!=', 1);

        if(auth()->user()->user_type_id != 1){
            $users = $users->where('created_by', auth()->user()->id);
        }

        $stats = [
            'all'       => (clone $users)->count(),
            'pending'   => (clone $users)->where('status', 0)->count(),
            'approved'  => (clone $users)->where('status', 1)->count(),
            'suspended' => (clone $users)->where('status', 2)->count(),
        ];

        $users = $users->when($this->filters['name'], function ($q) {
            $q->where('name', 'like', '%' . $this->filters['name'] . '%');
        })
        ->when($this->filters['email'], function ($q) {
            $q->where('email', $this->filters['email']);
        })
        ->when($this->filters['status'], function ($q) {
            $q->where('status', $this->filters['status']);
        })
        ->when($this->filters['from'], function ($q) {
            $q->whereDate('created_at', '>=', $this->filters['from']);
        })
        ->when($this->filters['to'], function ($q) {
            $q->whereDate('created_at', '<=', $this->filters['to']);
        });

        $users = $users->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.user.user-list', compact('users', 'stats'));
    }
}
