<?php

use App\Models\User;
use App\Models\DataRequest;
use App\Models\Opd;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can create a data request', function () {
    $user = User::factory()->create();
    $opd = Opd::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('user.data-requests.store'), [
        'nama_data' => 'Data Kependudukan',
        'opd_id' => $opd->id,
        'tujuan_penggunaan' => 'Untuk penelitian akademis di universitas.',
        'format_data' => ['excel', 'pdf'],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('data_requests', [
        'nama_data' => 'Data Kependudukan',
        'user_id' => $user->id,
    ]);
});

test('admin can upload data file', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);
    $dataRequest = DataRequest::factory()->create(['status' => 'diajukan']);
    $file = UploadedFile::fake()->create('data.xlsx', 100);

    $this->actingAs($admin);

    $response = $this->post(route('admin.data-requests.upload', $dataRequest), [
        'data_file' => $file,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('data_requests', [
        'id' => $dataRequest->id,
        'status' => 'tersedia',
        'file_name' => 'data.xlsx',
    ]);
    
    // File exists in storage (path is dynamic based on logic, usually in data-requests folder)
    // We just check db update as primary success indicator here
});

test('user can download available data', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $dataRequest = DataRequest::factory()->create([
        'user_id' => $user->id,
        'status' => 'tersedia',
        'file_path' => 'data-requests/test.xlsx',
        'file_name' => 'test.xlsx'
    ]);
    
    // Create dummy file
    Storage::disk('public')->put('data-requests/test.xlsx', 'content');

    $this->actingAs($user);

    $response = $this->get(route('user.data-requests.download', $dataRequest));
    $response->assertStatus(200);
});
