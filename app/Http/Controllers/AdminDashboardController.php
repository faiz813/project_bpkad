<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Exports\TamuExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with guest data.
     */
    public function index(Request $request)
    {
        $query = Tamu::query()->orderBy('created_at', 'desc');

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhere('tujuan_lainnya', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('bidang', 'like', "%{$search}%");
            });
        }

        $tamus = $query->paginate(15)->withQueryString();

        // Statistics
        $today = Carbon::today();
        $stats = [
            'today'     => Tamu::whereDate('created_at', $today)->count(),
            'this_week' => Tamu::whereBetween('created_at', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->count(),
            'this_month'=> Tamu::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->count(),
            'total'     => Tamu::count(),
            'active'    => Tamu::where('status_kunjungan', 'Aktif')->count(),
        ];

        $bidangOptions = TamuController::BIDANG_OPTIONS;

        return view('admin.dashboard', compact('tamus', 'stats', 'bidangOptions'));
    }

    /**
     * Update guest details (edit typo, nama, alamat, no_hp, bidang, tujuan).
     */
    public function update(Request $request, Tamu $tamu)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string|max:1000',
            'no_hp'        => 'required|string|max:20',
            'bidang'       => 'required|string|max:255',
            'tujuan'       => 'required|string|max:1000',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'bidang.required'       => 'Bidang yang dituju wajib diisi.',
            'tujuan.required'       => 'Tujuan / Keperluan wajib diisi.',
        ]);

        $tamu->update([
            'nama_lengkap'   => $validated['nama_lengkap'],
            'alamat'         => $validated['alamat'],
            'no_hp'          => $validated['no_hp'],
            'bidang'         => $validated['bidang'],
            'tujuan'         => $validated['tujuan'],
            'tujuan_lainnya' => null,
        ]);

        return back()->with('success', "Data tamu {$tamu->nama_lengkap} berhasil diperbarui.");
    }

    /**
     * Soft delete a guest record.
     */
    public function destroy(Tamu $tamu)
    {
        $nama = $tamu->nama_lengkap;
        $tamu->delete();

        return back()->with('success', "Data tamu {$nama} berhasil dihapus.");
    }

    /**
     * Checkout a guest — mark visit as completed.
     */
    public function checkout(Tamu $tamu)
    {
        $tamu->update([
            'status_kunjungan' => 'Selesai',
            'checkout_at'      => now(),
        ]);

        return back()->with('success', "Kunjungan tamu {$tamu->nama_lengkap} berhasil diselesaikan.");
    }

    /**
     * Export data to Excel.
     */
    public function exportExcel(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $search = $request->search;

        $filename = 'data-tamu-bpkad-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new TamuExport($dateFrom, $dateTo, $search), $filename);
    }

    /**
     * Export data to PDF with period options: perhari, perminggu, perbulan, pertahun.
     */
    public function exportPdf(Request $request)
    {
        $periode = $request->query('periode'); // 'hari', 'minggu', 'bulan', 'tahun', or null
        $query = Tamu::query()->orderBy('created_at', 'desc');

        $nowWib = now()->setTimezone('Asia/Jakarta');
        $periodeTitle = 'Semua Riwayat Kunjungan';
        $filenamePrefix = 'laporan-tamu-bpkad';

        if ($periode === 'hari') {
            $tanggal = $request->query('tanggal') ?: $nowWib->format('Y-m-d');
            $date = Carbon::parse($tanggal)->setTimezone('Asia/Jakarta');
            $query->whereDate('created_at', $date->toDateString());
            $periodeTitle = 'Laporan Harian (' . $date->translatedFormat('l, d F Y') . ')';
            $filenamePrefix = 'laporan-tamu-harian-' . $date->format('Y-m-d');
        } elseif ($periode === 'minggu') {
            $tanggal = $request->query('tanggal') ?: $nowWib->format('Y-m-d');
            $date = Carbon::parse($tanggal)->setTimezone('Asia/Jakarta');
            $startOfWeek = $date->copy()->startOfWeek();
            $endOfWeek = $date->copy()->endOfWeek();
            $query->whereBetween('created_at', [$startOfWeek->copy()->startOfDay(), $endOfWeek->copy()->endOfDay()]);
            $periodeTitle = 'Laporan Mingguan (' . $startOfWeek->translatedFormat('d F Y') . ' s/d ' . $endOfWeek->translatedFormat('d F Y') . ')';
            $filenamePrefix = 'laporan-tamu-mingguan-' . $startOfWeek->format('Ymd') . '-sd-' . $endOfWeek->format('Ymd');
        } elseif ($periode === 'bulan') {
            $bulan = (int) ($request->query('bulan') ?: $nowWib->month);
            $tahun = (int) ($request->query('tahun') ?: $nowWib->year);
            $query->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);
            $dateObj = Carbon::createFromDate($tahun, $bulan, 1)->setTimezone('Asia/Jakarta');
            $periodeTitle = 'Laporan Bulanan (' . $dateObj->translatedFormat('F Y') . ')';
            $filenamePrefix = 'laporan-tamu-bulanan-' . $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        } elseif ($periode === 'tahun') {
            $tahun = (int) ($request->query('tahun') ?: $nowWib->year);
            $query->whereYear('created_at', $tahun);
            $periodeTitle = 'Laporan Tahunan (Tahun ' . $tahun . ')';
            $filenamePrefix = 'laporan-tamu-tahunan-' . $tahun;
        } else {
            // Check for date_from / date_to
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $query->whereDate('created_at', '>=', $request->date_from)
                      ->whereDate('created_at', '<=', $request->date_to);
                $dFrom = Carbon::parse($request->date_from)->translatedFormat('d M Y');
                $dTo = Carbon::parse($request->date_to)->translatedFormat('d M Y');
                $periodeTitle = "Periode: {$dFrom} s/d {$dTo}";
                $filenamePrefix = 'laporan-tamu-' . $request->date_from . '-sd-' . $request->date_to;
            } elseif ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
                $periodeTitle = 'Mulai ' . Carbon::parse($request->date_from)->translatedFormat('d M Y');
                $filenamePrefix = 'laporan-tamu-dari-' . $request->date_from;
            } elseif ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
                $periodeTitle = 'Sampai ' . Carbon::parse($request->date_to)->translatedFormat('d M Y');
                $filenamePrefix = 'laporan-tamu-sampai-' . $request->date_to;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhere('tujuan_lainnya', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('bidang', 'like', "%{$search}%");
            });
        }

        $tamus = $query->get();

        $pdf = Pdf::loadView('exports.tamu-pdf', [
            'tamus'        => $tamus,
            'periodeTitle' => $periodeTitle,
            'tanggal'      => $nowWib->translatedFormat('d F Y, H:i') . ' WIB',
        ])->setPaper('a4', 'landscape');

        if ($request->query('stream') === '1') {
            return $pdf->stream($filenamePrefix . '.pdf');
        }

        return $pdf->download($filenamePrefix . '.pdf');
    }

    /**
     * API endpoint for polling new guests (AJAX).
     */
    public function getNewGuests(Request $request)
    {
        $lastCheck = $request->query('last_check');

        if ($lastCheck) {
            $newGuests = Tamu::where('created_at', '>', $lastCheck)
                ->orderBy('created_at', 'desc')
                ->get(['id', 'nama_lengkap', 'tujuan', 'tujuan_lainnya', 'created_at']);
        } else {
            $newGuests = collect();
        }

        return response()->json([
            'count'      => $newGuests->count(),
            'guests'     => $newGuests,
            'checked_at' => now()->toIso8601String(),
        ]);
    }
}
