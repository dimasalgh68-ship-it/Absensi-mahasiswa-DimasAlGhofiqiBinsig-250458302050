<?php

namespace App\Livewire\User;

use App\Models\Bill;
use Livewire\Component;
use Livewire\WithFileUploads;

class BillsComponent extends Component
{
    use WithFileUploads;

    public $showUploadModal = false;
    public $selectedBillId = null;
    public $proof;

    protected $rules = [
        'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    public function openUploadModal($billId)
    {
        $this->selectedBillId = $billId;
        $this->showUploadModal = true;
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->selectedBillId = null;
        $this->proof = null;
    }

    public function uploadProof()
    {
        $this->validate();

        $bill = Bill::findOrFail($this->selectedBillId);

        // Ensure the bill belongs to the current user
        if ($bill->user_id !== auth()->id()) {
            abort(403);
        }

        $proofPath = $this->proof->store('proofs', 'public');

        $bill->update([
            'proof_path' => $proofPath,
        ]);

        session()->flash('message', 'Bukti transfer berhasil diupload.');
        $this->closeUploadModal();
    }

    public function render()
    {
        $bills = Bill::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.user.bills-component', [
            'bills' => $bills,
        ]);
    }
}
