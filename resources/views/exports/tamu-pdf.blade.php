<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $periodeTitle ?? 'Data Tamu BPKAD' }}</title>
    <style>
        @page {
            margin: 12mm 12mm 14mm 12mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif; font-size: 10px; color: #1e293b; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2.5px double #1e3a5f; }
        .header h1 { font-size: 15px; color: #0f172a; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.8px; font-weight: bold; }
        .header h2 { font-size: 12px; color: #1e3a5f; margin-bottom: 3px; font-weight: bold; letter-spacing: 0.5px; }
        .header p { font-size: 9.5px; color: #64748b; }
        
        .meta-box { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 9.5px; }
        .meta-box td { border: none; padding: 2px 0; }
        .meta-box .title { font-size: 11px; font-weight: bold; color: #1e3a5f; }
        .meta-box .right { text-align: right; color: #475569; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data-table th { background-color: #1e3a5f; color: #ffffff; padding: 7px 6px; text-align: left; font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.3px; border: 1px solid #1e3a5f; }
        table.data-table td { padding: 6px 6px; border: 1px solid #cbd5e1; font-size: 9px; vertical-align: top; color: #1e293b; }
        table.data-table tr:nth-child(even) td { background-color: #f8fafc; }
        
        .no-col { width: 28px; text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8.5px; font-weight: bold; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-done { background: #f1f5f9; color: #475569; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 8.5px; color: #94a3b8; padding-top: 6px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Badan Pengelolaan Keuangan dan Aset Daerah</h1>
        <h2>PEMERINTAH KABUPATEN BOGOR &bull; BPKAD</h2>
        <p>Laporan Rekapitulasi Data Kehadiran Buku Tamu</p>
    </div>

    <table class="meta-box">
        <tr>
            <td>
                <span style="color: #64748b;">Periode Laporan:</span><br>
                <span class="title">{{ $periodeTitle ?? 'Semua Data' }}</span>
            </td>
            <td class="right">
                <span>Waktu Cetak: <strong>{{ $tanggal }}</strong></span><br>
                <span>Total Data: <strong>{{ $tamus->count() }} Tamu</strong></span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th style="width: 100px;">Waktu Kunjungan</th>
                <th style="width: 130px;">Nama Lengkap</th>
                <th style="width: 130px;">Alamat / Instansi</th>
                <th style="width: 90px;">No. HP</th>
                <th style="width: 120px;">Bidang Dituju</th>
                <th>Tujuan / Keperluan</th>
                <th style="width: 60px; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tamus as $index => $tamu)
            <tr>
                <td class="no-col">{{ $index + 1 }}</td>
                <td>{{ $tamu->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
                <td><strong>{{ $tamu->nama_lengkap }}</strong></td>
                <td>{{ $tamu->alamat }}</td>
                <td>{{ $tamu->no_hp }}</td>
                <td>{{ $tamu->bidang ?? '-' }}</td>
                <td>{{ $tamu->tujuan_display }}</td>
                <td style="text-align: center;">
                    <span class="badge {{ $tamu->status_kunjungan === 'Selesai' ? 'badge-done' : 'badge-active' }}">
                        {{ $tamu->status_kunjungan ?? 'Aktif' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 25px; color: #94a3b8; font-style: italic;">
                    Tidak ada catatan kunjungan tamu pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen dicetak secara otomatis oleh Sistem Buku Tamu Digital BPKAD &bull; Periode: {{ $periodeTitle ?? 'Semua Data' }} &bull; Waktu: {{ $tanggal }}
    </div>
</body>
</html>
