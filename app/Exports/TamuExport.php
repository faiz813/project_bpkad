<?php

namespace App\Exports;

use App\Models\Tamu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TamuExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected ?string $dateFrom;
    protected ?string $dateTo;
    protected ?string $search;

    public function __construct(?string $dateFrom = null, ?string $dateTo = null, ?string $search = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->search = $search;
    }

    public function query()
    {
        $query = Tamu::query()->orderBy('created_at', 'desc');

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhere('tujuan_lainnya', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('bidang', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal & Waktu',
            'Nama Lengkap',
            'Alamat',
            'No. HP/WhatsApp',
            'Bidang Dituju',
            'Tujuan/Keperluan',
            'Status',
            'Waktu Checkout',
        ];
    }

    public function map($tamu): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $tujuan = $tamu->tujuan === 'Lainnya' && $tamu->tujuan_lainnya
            ? $tamu->tujuan_lainnya
            : $tamu->tujuan;

        return [
            $rowNumber,
            $tamu->created_at->format('d/m/Y H:i'),
            $tamu->nama_lengkap,
            $tamu->alamat,
            $tamu->no_hp,
            $tamu->bidang ?? '-',
            $tujuan,
            $tamu->status_kunjungan ?? 'Aktif',
            $tamu->checkout_at ? $tamu->checkout_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e3a5f'],
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => 'ffffff']],
            ],
        ];
    }
}
