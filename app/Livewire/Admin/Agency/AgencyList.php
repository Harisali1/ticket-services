<?php

namespace App\Livewire\Admin\Agency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Agency;
use Auth;

class AgencyList extends Component
{
    use WithPagination;
    public $selectedAgencyId;
    public $adminPassword;
    public $agencyPassword;
    public $showPassword = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'adminPassword' => 'required'
    ];

    public $filters = [
        'agency_name' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 10;

    public function openPasswordModal($agencyId)
    {
        $this->reset(['adminPassword', 'agencyPassword', 'showPassword']);
        $this->selectedAgencyId = $agencyId;

        $this->dispatch('open-password-modal');
    }

    public function verifyAdminPassword()
    {
        $this->validate();

        if (!Auth::attempt(['email' => auth()->user()->email,'password' => $this->adminPassword])) {
            $this->addError('adminPassword', 'Incorrect admin password');
            return;
        }

        $agency = Agency::findOrFail($this->selectedAgencyId);

        // ⚠️ RECOMMENDED: encrypted password
        $this->agencyPassword = $agency->show_pass;

        $this->showPassword = true;
    }

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

    public function filterStatus($status)
    {
        
        $this->filters['status'] = ($status == 0) ? '' : $status;
    }

    public function render()
    {
        $agencies = Agency::where('is_deleted', 0);
        
        if(auth()->user()->user_type_id != 1){
            $agencies = $agencies->where('created_by', auth()->user()->id);
        }

        $all = (clone $agencies)->count();
        $pending   = (clone $agencies)->where('status', 1)->count();
        $approved  = (clone $agencies)->where('status', 2)->count();
        $suspended = (clone $agencies)->where('status', 3)->count();

        $agencies = $agencies->when($this->filters['agency_name'], fn ($q) =>
            $q->where('name', 'like', '%' . $this->filters['agency_name'] . '%')
        )
        ->when($this->filters['status'] !== '', fn ($q) =>
            $q->where('status', $this->filters['status'])
        )
        ->when($this->filters['from'], fn ($q) =>
            $q->whereDate('created_at', '>=', $this->filters['from'])
        )
        ->when($this->filters['to'], fn ($q) =>
            $q->whereDate('created_at', '<=', $this->filters['to'])
        );

        $agencies = $agencies->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.agency.agency-list', compact('agencies', 'all', 'pending', 'approved', 'suspended'));
    }
}
