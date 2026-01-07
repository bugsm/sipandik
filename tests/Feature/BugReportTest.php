<?php

use App\Models\User;
use App\Models\BugReport;
use App\Models\Application;
use App\Models\VulnerabilityType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->mock(\App\Services\NotificationService::class, function ($mock) {
        $mock->shouldReceive('notifyBugReportSubmitted');
        $mock->shouldReceive('notifyBugReportStatusUpdate');
    });
});


test('it prevents unauthenticated access to bug reports', function () {
    $response = $this->get(route('user.bug-reports.index'));
    $response->assertRedirect(route('login'));
});

test('user can view their own bug reports', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('user.bug-reports.index'));
    $response->assertStatus(200);
});

test('user can create a bug report', function () {
    $user = User::factory()->create();
    $application = Application::factory()->create();
    $vulnerability = VulnerabilityType::factory()->create();

    $this->actingAs($user);



    $response = $this->post(route('user.bug-reports.store'), [
        'application_id' => $application->id,
        'vulnerability_type_id' => $vulnerability->id,
        'judul' => 'Test Bug Report',
        'deskripsi' => 'This is a test description with more than 20 characters.',
        'tanggal_kejadian' => now()->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('bug_reports', [
        'judul' => 'Test Bug Report',
        'user_id' => $user->id,
    ]);
});

test('user cannot view bug reports belonging to others', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $bugReport = BugReport::factory()->create(['user_id' => $user2->id]);

    $this->actingAs($user1);
    
    $response = $this->get(route('user.bug-reports.show', $bugReport));
    $response->assertStatus(403);
});

test('admin can update bug report status', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $bugReport = BugReport::factory()->create(['status' => 'diajukan']);

    $this->actingAs($admin);

    $response = $this->patch(route('admin.bug-reports.update-status', $bugReport), [
        'status' => 'diproses',
        'catatan' => 'Processing request',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('bug_reports', [
        'id' => $bugReport->id,
        'status' => 'diproses',
    ]);
});
