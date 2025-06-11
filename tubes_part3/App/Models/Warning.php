<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;

    // Field yang bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'admin_id',
        'warning_type',
        'subject',
        'message',
        'status',
        'expires_at',
    ];

    // Cast kolom expires_at menjadi tipe datetime
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relasi dengan User yang diperingatkan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi dengan Admin yang mengeluarkan peringatan
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id'); // Asumsi admin juga menggunakan model User
    }
}