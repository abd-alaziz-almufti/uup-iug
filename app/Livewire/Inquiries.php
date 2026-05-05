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
    public $course_id = '';
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

        $cacheKey = 'student_tickets_' . auth()->id();
        
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () { // 5 minutes TTL
            $tickets = Ticket::with([
                'department:id,name', 
                'replies.user:id,name', 
                'course:id,name'
            ])
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
                    "subject" => $ticket->content ?? $ticket->replies->first()?->reply_text ?? 'لا يوجد تفاصيل',
                    "replies" => $ticket->replies->map(function ($reply) {
                        return [
                            "id" => $reply->id,
                            "author" => $reply->user ? $reply->user->name : 'الدعم',
                            "message" => $reply->reply_text,
                            "created_at" => $reply->created_at->format('d/m/Y H:i'),
                        ];
                    })->toArray(),
                ];
            })->toArray();
        });
    }

    #[Computed]
    public function studentCourses()
    {
        if (!auth()->check()) return collect();
        
        return \Illuminate\Support\Facades\Cache::remember('student_courses_' . auth()->id(), 60 * 60 * 24, function () {
            return \App\Models\Course::whereHas('enrollments', function ($query) {
                $query->where('student_id', auth()->id());
            })->get(['id', 'name']);
        });
    }

    #[Computed]
    public function availableTargetTypes()
    {
        if (!$this->department_id) return [];

        $dept = $this->departmentsList->firstWhere('id', $this->department_id);
        if (!$dept) return [];

        $types = [];

        // استخدام حقل type بدلاً من اسم القسم لمرونة أعلى
        if ($dept->type === 'academic' || $dept->type === 'faculty') {
            $types = [
                ['value' => 'supervisor', 'label' => 'المشرف الأكاديمي'],
                ['value' => 'dean', 'label' => 'عميد الكلية'],
                ['value' => 'instructor', 'label' => 'مدرس المادة'],
            ];
        } elseif ($dept->type === 'admission') {
            $types = [
                ['value' => 'admission', 'label' => 'موظف القبول والتسجيل'],
            ];
        } else {
            // Default for other departments
            $types = [
                ['value' => 'supervisor', 'label' => 'رئيس الدائرة'],
                ['value' => 'instructor', 'label' => 'موظف مختص'],
            ];
        }

        return $types;
    }

    #[Computed]
    public function departmentsList()
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('departments_list', function () {
            return Department::all(['id', 'name', 'type']); // جلب حقل type
        });
    }

    public function selectTicket($id)
    {
        $this->selectedId = $id;
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['title', 'subject', 'department_id', 'targetType', 'course_id', 'attachment']);
        
        // Auto-select first department if available
        $firstDept = $this->departmentsList->first();
        if ($firstDept) {
            $this->department_id = $firstDept->id;
            // Set default target type from available ones
            $available = $this->availableTargetTypes;
            if (count($available) > 0) {
                $this->targetType = $available[0]['value'];
            }
        }

        $this->showCreateModal = true;
    }

    public function createTicket()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'category' => 'required',
            'targetType' => 'required',
        ];

        if ($this->targetType === 'instructor') {
            $rules['course_id'] = 'required|exists:courses,id';
        }

        $this->validate($rules, [
            'title.required' => 'يرجى إدخال عنوان التذكرة',
            'subject.required' => 'يرجى إدخال موضوع التذكرة',
            'department_id.required' => 'يرجى اختيار الجهة المرسل إليها',
            'category.required' => 'يرجى اختيار التصنيف',
            'course_id.required' => 'يرجى اختيار المادة الدراسية',
        ]);

        try {
            $ticket = Ticket::create([
                'title' => $this->title,
                'content' => $this->subject,
                'category' => $this->category,
                'department_id' => (int)$this->department_id,
                'target_type' => $this->targetType,
                'course_id' => $this->targetType === 'instructor' ? (int)$this->course_id : null,
                'status' => 'open',
                'priority' => 'medium',
                'student_id' => (int)auth()->id(),
            ]);

            $this->showCreateModal = false;
            $this->selectedId = $ticket->ticket_code;
            
            \Illuminate\Support\Facades\Cache::forget('student_tickets_' . auth()->id());
            unset($this->tickets);
            
            session()->flash('message', 'تم إنشاء التذكرة بنجاح برقم: ' . $ticket->ticket_code);
            
        } catch (\Exception $e) {
            \Log::error('Inquiries Create Error: ' . $e->getMessage());
            session()->flash('error', 'عذراً، حدث خطأ أثناء حفظ التذكرة، يرجى المحاولة لاحقاً.'); // رسالة آمنة للمستخدم
        }
    }

    public function updatedDepartmentId($value)
    {
        $available = $this->availableTargetTypes;
        if (count($available) > 0) {
            $this->targetType = $available[0]['value'];
        } else {
            $this->targetType = '';
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
