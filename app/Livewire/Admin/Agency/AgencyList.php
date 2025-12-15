<?php

namespace App\Livewire\Admin\Agency;

use Livewire\Component;
use App\Models\Admin\Agency;

class AgencyList extends Component
{
    public $filters = [
        'agency_name' => '',
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
        $agencies = Agency::query()
            ->when($this->filters['agency_name'], function ($q) {
                $q->where('name', 'like', '%' . $this->filters['agency_name'] . '%');
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
            'all'       => Agency::count(),
            'pending'   => Agency::where('status', 0)->count(),
            'approved'  => Agency::where('status', 1)->count(),
            'suspended' => Agency::where('status', 2)->count(),
        ];

        return view('livewire.admin.agency.agency-list', compact('agencies', 'stats'));
    }
}
