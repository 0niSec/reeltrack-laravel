<?php

namespace App\Models;

use App\Contracts\Watchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $fillable = [
        'event_type',
        'action',
        'metadata',
        'user_id',
        'subject_id',
        'subject_type',
    ];

    public static function log(
        User $user,
        Watchable $subject,
        string $eventType,
        string $action,
        array $metadata = []
    ): self {
        return self::create([
            'user_id' => $user->id,
            'subject_id' => $subject->id,
            'subject_type' => get_class($subject),
            'event_type' => $eventType,
            'action' => $action,
            'metadata' => $metadata,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
}
