<?php

namespace App\Livewire\Admin\Notification;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Notification;

class NotificationList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'title' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 10;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

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
        $notifications = Notification::query()
            ->when($this->filters['title'], fn ($q) =>
                $q->where('title', 'like', '%' . $this->filters['title'] . '%')
            )
            ->when($this->filters['status'] !== '', fn ($q) =>
                $q->where('status', $this->filters['status'])
            )
            ->when($this->filters['from'], fn ($q) =>
                $q->whereDate('created_at', '>=', $this->filters['from'])
            )
            ->when($this->filters['to'], fn ($q) =>
                $q->whereDate('created_at', '<=', $this->filters['to'])
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.notification.notification-list', compact('notifications'));
    }
}
