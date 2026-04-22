<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use App\Models\Ticket;
use App\Models\Department;

class Inquiries extends Component
{
    use WithFileUploads;

    public $query = '';
    public $selectedId = null;
    public $showCreateModal = false;

    // Create Ticket Form
    public $department_id = '';
    public $targetType = 'supervisor';
    public $category = 'أخرى';
    public $title = '';
    public $subject = '';
    public $attachment;

    public function mount()
    {
        $firstTicket = collect($this->tickets)->first();
        $this->selectedId = $firstTicket['id'] ?? null;
    }

    /**
     * Eager Loading is applied here (with 'department' and 'replies.user') 
     * to avoid the N+1 Queries problem and drastically improve performance.
     */
    #[Computed]
    public function tickets()
    {
        if (!auth()->check()) {
            return [];
        }

        $tickets = Ticket::with(['department', 'replies.user', 'course'])
            ->where('student_id', auth()->id())
            ->latest()
            ->get();

        return $tickets->map(function ($ticket) {
            return [
                "id" => $ticket->ticket_code ?? $ticket->id,
                "title" => $ticket->title,
                "target" => $ticket->department ? $ticket->department->name : 'بدون قسم',
                "status" => in_array($ticket->status, ['open', 'in_progress']) ? 'قيد المتابعة' : 'مغلق',
                "openedAt" => $ticket->created_at->format('d/m/Y'),
                "closedAt" => in_array($ticket->status, ['resolved', 'closed']) ? $ticket->updated_at->format('d/m/Y') : '--/--/----',
                "subject" => $ticket->content ?? 'لا يوجد تفاصيل',
                "replies" => $ticket->replies->map(function ($reply) {
                    return [
                        "id" => $reply->id,
                        "author" => $reply->user ? $reply->user->name : 'الدعم',
                        "message" => $reply->message,
                        "created_at" => $reply->created_at->format('d/m/Y H:i'),
                    ];
                })->toArray(),
            ];
        })->toArray();
    }

    #[Computed]
    public function departmentsList()
    {
        return Department::all(['id', 'name']);
    }

    public function selectTicket($id)
    {
        $this->selectedId = $id;
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['title', 'subject', 'department_id', 'targetType', 'attachment']);
        
        // Auto-select first department if available
        $firstDept = $this->departmentsList->first();
        if ($firstDept) {
            $this->department_id = $firstDept->id;
        }

        if (auth()->check()) {
            session()->flash('debug_auth', 'جاري الإنشاء للمستخدم رقم: ' . auth()->id());
        }

        $this->showCreateModal = true;
    }

    public function createTicket()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'department_id' => 'required',
            'category' => 'required',
        ], [
            'title.required' => 'يرجى إدخال عنوان التذكرة',
            'subject.required' => 'يرجى إدخال موضوع التذكرة',
            'department_id.required' => 'يرجى اختيار الجهة المرسل إليها',
            'category.required' => 'يرجى اختيار التصنيف',
        ]);

        try {
            $ticket = Ticket::create([
                'title' => $this->title,
                'category' => $this->category,
                'department_id' => (int)$this->department_id,
                'target_type' => $this->targetType,
                'status' => 'open',
                'priority' => 'medium',
                'student_id' => (int)auth()->id(),
            ]);

            $ticket->replies()->create([
                'user_id' => auth()->id(),
                'reply_text' => $this->subject,
            ]);

            $this->showCreateModal = false;
            $this->selectedId = $ticket->ticket_code;
            
            unset($this->tickets);
            session()->flash('message', 'تم إنشاء التذكرة بنجاح برقم: ' . $ticket->ticket_code);
            
        } catch (\Exception $e) {
            \Log::error('Inquiries Create Error: ' . $e->getMessage());
            session()->flash('error', 'فشل الحفظ: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $filteredTickets = collect($this->tickets)->filter(function ($ticket) {
            if (!$this->query) return true;
            $q = strtolower(trim($this->query));
            return str_contains(strtolower($ticket['id']), $q) ||
                   str_contains(strtolower($ticket['title']), $q) ||
                   str_contains(strtolower($ticket['target']), $q);
        })->values();

        $selectedTicket = collect($this->tickets)->firstWhere('id', $this->selectedId);

        return view('livewire.inquiries', [
            'filteredTickets' => $filteredTickets,
            'selectedTicket' => $selectedTicket,
        ]);
    }
}
