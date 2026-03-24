<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'university_id',
        'name',
        'email',
        'password',
        'department_id',
    ];


    public function canAccessPanel(Panel $panel): bool
    {
        return ! $this->hasRole('Student'); // Prevent students from accessing the admin dashboard
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * القسم (Department) للمستخدم
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * التذاكر اللي فتحها هذا الطالب
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'student_id');
    }

    /**
     * التذاكر المعينة لهذا الموظف
     */
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    /**
     * الردود على التذاكر
     */
    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class);
    }

    /**
     * الإعلانات اللي نشرها
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'published_by');
    }



    /**
     * الأدلة اللي رفعها
     */
    public function guides()
    {
        return $this->hasMany(Guide::class, 'created_by');
    }

    /**
     * المنشورات
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * الرسائل المرسلة
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * الرسائل المستلمة
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * المواد المسجلة
     */
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class, 'student_id');
    }

    /**
     * سجل النشاطات
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * تاريخ التذاكر
     */
    public function ticketHistories()
    {
        return $this->hasMany(TicketHistory::class);
    }

    /**
     * معلومات الاتصال (لو الشخص له صفحة اتصال)
     */
    public function contact()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * فحص لو المستخدم طالب
     */
    public function isStudent()
    {
        return $this->hasRole('Student');
    }

    /**
     * فحص لو المستخدم موظف
     */
    public function isStaff()
    {
        return $this->hasRole('Support Agent');
    }

    /**
     * فحص لو المستخدم مدير
     */
    public function isAdmin()
    {
        return $this->hasRole('Super Admin') || $this->hasRole('super_admin');
    }
}
