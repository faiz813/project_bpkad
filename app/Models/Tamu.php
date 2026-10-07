<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tamu extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'no_hp',
        'tujuan',
        'tujuan_lainnya',
        'bidang',
        'tanda_tangan',
        'status_kunjungan',
        'checkout_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'checkout_at' => 'datetime',
    ];

    /**
     * Get the tujuan display text.
     */
    public function getTujuanDisplayAttribute(): string
    {
        if ($this->tujuan === 'Lainnya' && $this->tujuan_lainnya) {
            return $this->tujuan_lainnya;
        }
        return $this->tujuan;
    }
}
