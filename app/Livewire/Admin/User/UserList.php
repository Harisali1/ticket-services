<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;

class UserList extends Component
{
    public $filters = [
        'name' => '',
        'email' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public function applyFilters()
    {
        // Just re-render
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->filters['name'], function ($q) {
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
            })
            ->latest()
            ->get();

        $stats = [
            'all'       => User::count(),
            'pending'   => User::where('status', 0)->count(),
            'approved'  => User::where('status', 1)->count(),
            'suspended' => User::where('status', 2)->count(),
        ];

        return view('livewire.admin.user.user-list', compact('users', 'stats'));
    }
}
