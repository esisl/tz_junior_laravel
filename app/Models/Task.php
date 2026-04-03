<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать
     */
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * Атрибуты, которые нужно кастить к определённым типам
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Допустимые значения статуса
     */
    public const STATUSES = [
        'pending',
        'in_progress',
        'completed',
    ];

    /**
     * Проверка, является ли статус допустимым
     */
    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::STATUSES, true);
    }

    /**
     * Scope для фильтрации по статусу
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}