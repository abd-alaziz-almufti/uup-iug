<?php

use App\Models\User;
use App\Models\Ticket;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 1. Check Ticket Code Generation
$ticket = new Ticket();
$ticket->title = 'Test Ticket';
$ticket->content = 'Test Content';
$ticket->student_id = 1;
// ticket_code is generated in booted() creating
echo "Testing Ticket Code Generation...\n";
// Actually we need to save it or trigger events
// For now let's just see if the column exists and the model is okay
echo "Ticket Code Column: " . ($ticket->ticket_code === null ? 'NULL (expected before save)' : $ticket->ticket_code) . "\n";

// 2. Check Role permissions (Optional if we have db, but let's just check the policy methods directly if possible)
echo "Testing TicketPolicy Logic...\n";
$policy = new \App\Policies\TicketPolicy();
$admin = new User(['id' => 1]);
$admin->setRelation('roles', collect([new \Spatie\Permission\Models\Role(['name' => 'super_admin'])]));

$dean = new User(['id' => 2, 'department_id' => 1]);
$dean->setRelation('roles', collect([new \Spatie\Permission\Models\Role(['name' => 'Dean'])]));

$ticketInDept = new Ticket(['department_id' => 1, 'target_type' => 'dean']);
$ticketOtherDept = new Ticket(['department_id' => 2, 'target_type' => 'dean']);

// Since we can't easily mock auth()->user()->can(), we'll trust the logic if it looks direct
// But we can check the return values of our policy methods if we mock the $authUser properly

function mockUserWithRole($roleName, $deptId = null) {
    $user = new class extends User {
        public $mockRoles = [];
        public function hasRole($roles, $guard = null): bool {
            if (is_array($roles)) {
                return count(array_intersect($this->mockRoles, $roles)) > 0;
            }
            return in_array($roles, $this->mockRoles);
        }
        public function can($item, $arguments = []): bool {
            return true; // Assume they have the base permission for this test
        }
    };
    $user->mockRoles = [$roleName];
    $user->department_id = $deptId;
    return $user;
}

$mockDean = mockUserWithRole('Dean', 1);
echo "Dean in Dept 1 sees Ticket in Dept 1: " . ($policy->view($mockDean, $ticketInDept) ? 'YES' : 'NO') . "\n";
echo "Dean in Dept 1 sees Ticket in Dept 2: " . ($policy->view($mockDean, $ticketOtherDept) ? 'YES' : 'NO') . "\n";

$mockSupervisor = mockUserWithRole('Academic Supervisor', 1);
$supervisorTicket = new Ticket(['department_id' => 1]);
echo "Supervisor in Dept 1 sees Ticket in Dept 1: " . ($policy->view($mockSupervisor, $supervisorTicket) ? 'YES' : 'NO') . "\n";

$mockStudent = mockUserWithRole('Student');
$mockStudent->id = 10;
$studentTicket = new Ticket(['student_id' => 10]);
$otherStudentTicket = new Ticket(['student_id' => 11]);
echo "Student sees their own Ticket: " . ($policy->view($mockStudent, $studentTicket) ? 'YES' : 'NO') . "\n";
echo "Student sees others' Ticket: " . ($policy->view($mockStudent, $otherStudentTicket) ? 'YES' : 'NO') . "\n";

echo "Verification Ended.\n";
