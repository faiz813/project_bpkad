<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TamuTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_form_can_be_rendered(): void
    {
        $response = $this->get(route('tamu.create'));

        $response->assertStatus(200);
        $response->assertSee('Formulir Kehadiran Tamu');
        $response->assertSee('Live • Real-Time WIB');
        $response->assertSee('Tujuan / Keperluan Kunjungan');
        $response->assertSee('Masukkan keperluan atau tujuan kunjungan Anda secara spesifik...');
    }

    public function test_guest_can_register_with_direct_manual_purpose(): void
    {
        $purpose = 'Konsultasi penyusunan APBD Perubahan 2026 dan rekonsiliasi kas daerah';
        $captchaAnswer = 'AB3X7K'; // Fixed alphanumeric captcha code for test
        $payload = [
            'nama_lengkap' => 'Ahmad Fauzi',
            'alamat'       => 'Dinas Pendidikan Kab. Bogor',
            'no_hp'        => '081234567890',
            'bidang'       => 'Bidang Anggaran',
            'tujuan'       => $purpose,
            'captcha'      => $captchaAnswer,
        ];

        // Pre-seed session with the expected captcha answer
        session(['captcha_answer' => $captchaAnswer]);

        $response = $this->post(route('tamu.store'), $payload);

        $this->assertDatabaseHas('tamus', [
            'nama_lengkap' => 'Ahmad Fauzi',
            'tujuan'       => $purpose,
        ]);

        $tamu = Tamu::first();
        $this->assertEquals($purpose, $tamu->tujuan_display);
        $response->assertRedirect(route('tamu.success', $tamu));

        // Digital pass page
        $successResponse = $this->get(route('tamu.success', $tamu));
        $successResponse->assertStatus(200);
        $successResponse->assertSee('Pas Masuk Digital');
        $successResponse->assertSee($purpose);
        $successResponse->assertSee('WIB');
    }

    public function test_admin_can_update_guest_details(): void
    {
        $user = User::factory()->create();
        $tamu = Tamu::create([
            'nama_lengkap' => 'Budi Santoso',
            'alamat'       => 'Jl. Sudirman No. 1',
            'no_hp'        => '081234567890',
            'bidang'       => 'Sekretariat BPKAD',
            'tujuan'       => 'Menyerahkan surat',
        ]);

        $response = $this->actingAs($user)->put(route('admin.tamu.update', $tamu), [
            'nama_lengkap' => 'Budi Santoso, M.Si',
            'alamat'       => 'Bappeda Prov. Jabar',
            'no_hp'        => '081299998888',
            'bidang'       => 'Bidang Anggaran',
            'tujuan'       => 'Konsultasi revisi DPA TA 2026',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tamus', [
            'id'           => $tamu->id,
            'nama_lengkap' => 'Budi Santoso, M.Si',
            'alamat'       => 'Bappeda Prov. Jabar',
            'no_hp'        => '081299998888',
            'tujuan'       => 'Konsultasi revisi DPA TA 2026',
        ]);
    }

    public function test_admin_can_soft_delete_guest(): void
    {
        $user = User::factory()->create();
        $tamu = Tamu::create([
            'nama_lengkap' => 'Tamu Dihapus',
            'alamat'       => 'Alamat Tamu',
            'no_hp'        => '081122334455',
            'bidang'       => 'Lainnya / Keperluan Umum',
            'tujuan'       => 'Keperluan umum',
        ]);

        $response = $this->actingAs($user)->delete(route('admin.tamu.destroy', $tamu));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('tamus', [
            'id' => $tamu->id,
        ]);
    }

    public function test_timezone_is_asia_jakarta(): void
    {
        $this->assertEquals('Asia/Jakarta', config('app.timezone'));
    }

    public function test_admin_can_export_pdf_per_hari(): void
    {
        $user = User::factory()->create();
        Tamu::create([
            'nama_lengkap' => 'Tamu Hari Ini',
            'alamat'       => 'Cibinong',
            'no_hp'        => '081234567890',
            'bidang'       => 'Kepala BPKAD',
            'tujuan'       => 'Audiensi pimpinan',
            'created_at'   => now()->setTimezone('Asia/Jakarta'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.export.pdf', [
            'periode' => 'hari',
            'tanggal' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('laporan-tamu-harian-', $response->headers->get('Content-Disposition') ?? '');
    }

    public function test_admin_can_export_pdf_per_minggu(): void
    {
        $user = User::factory()->create();
        Tamu::create([
            'nama_lengkap' => 'Tamu Pekan Ini',
            'alamat'       => 'Bogor',
            'no_hp'        => '081234567890',
            'bidang'       => 'Sekretariat BPKAD',
            'tujuan'       => 'Koordinasi surat',
            'created_at'   => now()->setTimezone('Asia/Jakarta'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.export.pdf', [
            'periode' => 'minggu',
            'tanggal' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('laporan-tamu-mingguan-', $response->headers->get('Content-Disposition') ?? '');
    }

    public function test_admin_can_export_pdf_per_bulan(): void
    {
        $user = User::factory()->create();
        Tamu::create([
            'nama_lengkap' => 'Tamu Bulan Ini',
            'alamat'       => 'Bogor',
            'no_hp'        => '081234567890',
            'bidang'       => 'Bidang Anggaran',
            'tujuan'       => 'Penyusunan anggaran',
            'created_at'   => now()->setTimezone('Asia/Jakarta'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.export.pdf', [
            'periode' => 'bulan',
            'bulan'   => now()->setTimezone('Asia/Jakarta')->month,
            'tahun'   => now()->setTimezone('Asia/Jakarta')->year,
        ]));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('laporan-tamu-bulanan-', $response->headers->get('Content-Disposition') ?? '');
    }

    public function test_admin_can_export_pdf_per_tahun(): void
    {
        $user = User::factory()->create();
        Tamu::create([
            'nama_lengkap' => 'Tamu Tahun Ini',
            'alamat'       => 'Bogor',
            'no_hp'        => '081234567890',
            'bidang'       => 'Bidang Perbendaharaan',
            'tujuan'       => 'Pencairan dana',
            'created_at'   => now()->setTimezone('Asia/Jakarta'),
        ]);

        $response = $this->actingAs($user)->get(route('admin.export.pdf', [
            'periode' => 'tahun',
            'tahun'   => now()->setTimezone('Asia/Jakarta')->year,
        ]));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('laporan-tamu-tahunan-', $response->headers->get('Content-Disposition') ?? '');
    }
}
