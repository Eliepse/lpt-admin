<?php

namespace App;

use App\Relations\HasSubscribers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Subscription
 *
 * @package App
 * @property int $id
 * @property int $student_id
 * @property int $marketable_id
 * @property string $marketable_type
 * @property int $price
 * @property int $paid
 * @property Carbon $validity_start_at
 * @property Carbon|null $validity_end_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * Relations
 * @property Student $student
 * @property Model|HasSubscribers $marketable
 */
class Subscription extends Model
{
    protected $guarded = [];

    protected $dates = [
        'validity_start_at',
        'validity_end_at',
    ];


    public function marketable(): MorphTo
    {
        return $this->morphTo();
    }


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }


    public function unpaidAmount(): int
    {
        return $this->price - $this->paid;
    }


    public function isPaid(): bool
    {
        return $this->paid >= $this->price;
    }


    public function isOverPaid(): bool
    {
        return $this->paid > $this->price;
    }
}
