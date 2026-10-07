<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TamuController extends Controller
{
    /**
     * Daftar opsi tujuan/keperluan.
     */
    public const TUJUAN_OPTIONS = [
        'Konsultasi',
        'Pengambilan Dokumen',
        'Pengajuan Permohonan',
        'Koordinasi',
        'Audiensi',
        'Kunjungan Kerja',
        'Lainnya',
    ];

    /**
     * Daftar opsi bidang/sub-bagian yang dituju.
     */
    public const BIDANG_OPTIONS = [
        'Kepala BPKAD',
        'Sekretariat BPKAD',
        'Bidang Anggaran',
        'Bidang Perbendaharaan',
        'Bidang Akuntansi & Pelaporan Keuangan',
        'Bidang Pengelolaan Barang Milik Daerah / Aset',
        'Lainnya / Keperluan Umum',
    ];

    /**
     * Show the main portal landing page.
     */
    public function portal()
    {
        return view('portal');
    }

    /**
     * Generate a random alphanumeric captcha code and store it in session.
     * Characters: uppercase letters (excluding O, I) + digits (excluding 0, 1) — avoids ambiguous chars.
     */
    protected function generateCaptcha(): array
    {
        $chars  = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $length = 6;
        $code   = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        session(['captcha_answer' => strtoupper($code)]);

        return [
            'code' => $code,
        ];
    }

    /**
     * Refresh captcha via AJAX — returns a new alphanumeric code.
     */
    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();

        return response()->json([
            'code' => $captcha['code'],
        ]);
    }

    /**
     * Show the guest registration form.
     */
    public function create()
    {
        $captcha = $this->generateCaptcha();

        return view('tamu.create', [
            'bidangOptions' => self::BIDANG_OPTIONS,
            'captcha'       => $captcha,
        ]);
    }

    /**
     * Store a new guest entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'alamat'         => 'required|string|max:1000',
            'no_hp'          => 'required|string|regex:/^[0-9+\-\s]+$/|min:8|max:20',
            'bidang'         => 'required|string|max:255',
            'tujuan'         => 'required|string|max:1000',
            'tanda_tangan'   => 'nullable|string', // base64 data (optional)
            'captcha'        => ['required', function ($attribute, $value, $fail) {
                $expected = session('captcha_answer');
                // Case-insensitive comparison
                if (!$expected || strtoupper(trim((string)$value)) !== strtoupper((string)$expected)) {
                    $fail('Kode verifikasi captcha tidak sesuai. Periksa kembali huruf dan angka yang Anda masukkan.');
                }
            }],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'no_hp.required'        => 'No. HP/WhatsApp wajib diisi.',
            'no_hp.regex'           => 'No. HP/WhatsApp hanya boleh berisi angka.',
            'no_hp.min'             => 'No. HP/WhatsApp minimal 8 digit.',
            'bidang.required'       => 'Bidang/Sub-Bagian yang dituju wajib dipilih.',
            'tujuan.required'       => 'Tujuan / Keperluan kunjungan wajib diisi.',
            'captcha.required'      => 'Selesaikan verifikasi keamanan / captcha terlebih dahulu.',
        ]);

        // Save signature image from base64 if provided
        $signaturePath = null;
        if (!empty($validated['tanda_tangan'])) {
            $signaturePath = $this->saveSignature($validated['tanda_tangan']);
        }

        // Explicit real-time timestamp in Asia/Jakarta (WIB)
        $nowWib = now()->setTimezone('Asia/Jakarta');

        // Create the tamu record
        $tamu = Tamu::create([
            'nama_lengkap'   => $validated['nama_lengkap'],
            'alamat'         => $validated['alamat'],
            'no_hp'          => $validated['no_hp'],
            'bidang'         => $validated['bidang'],
            'tujuan'         => $validated['tujuan'],
            'tujuan_lainnya' => null,
            'tanda_tangan'   => $signaturePath,
            'created_at'     => $nowWib,
            'updated_at'     => $nowWib,
        ]);

        return redirect()->route('tamu.success', $tamu);
    }

    /**
     * Show the Pas Masuk Digital (digital entry pass) after form submission.
     */
    public function success(Tamu $tamu)
    {
        if (view()->exists('tamu.sukses')) {
            return view('tamu.sukses', compact('tamu'));
        }
        return view('tamu.success', compact('tamu'));
    }

    /**
     * Lookup guest data by phone number for auto-fill (AJAX).
     */
    public function lookupByPhone(Request $request)
    {
        $noHp = $request->query('no_hp');

        if (!$noHp || strlen($noHp) < 8) {
            return response()->json(['found' => false]);
        }

        $tamu = Tamu::where('no_hp', $noHp)
            ->orderBy('created_at', 'desc')
            ->first(['nama_lengkap', 'alamat']);

        if ($tamu) {
            return response()->json([
                'found'        => true,
                'nama_lengkap' => $tamu->nama_lengkap,
                'alamat'       => $tamu->alamat,
            ]);
        }

        return response()->json(['found' => false]);
    }

    /**
     * Save base64 signature to storage and return the path.
     */
    private function saveSignature(string $base64Data): string
    {
        // Remove data URI prefix if present
        $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);
        $imageData = base64_decode($base64Data);

        $filename = 'signatures/' . Str::uuid() . '.png';

        Storage::disk('public')->put($filename, $imageData);

        return $filename;
    }
}
