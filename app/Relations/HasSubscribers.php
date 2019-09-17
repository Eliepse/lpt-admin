<?php


namespace App\Relations;


use App\Student;
use App\Subscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * Trait HasSubscribers
 *
 * @package App\Relations
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 */
trait HasSubscribers
{
    abstract public function getPrice(): int;


    public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, "marketable");
    }


    public function getSubscribers(): Collection
    {
        return $this->subscriptions->pluck('student');
    }


    public function subscribe(HasSubscriptions $model)
    {
        $sub = new Subscription();
        $sub->student()->associate($model);
        $sub->price = $this->price;
        $sub->paid = 0;
        $sub->validity_start_at = $this->start_at;
        $sub->validity_end_at = $this->end_at;
        $this->subscriptions()->save($sub);

        return $sub;
    }


    public function findSubscription(Student $student): ?Subscription
    {
        return $this->subscriptions->firstWhere('student_id', $student->id);
    }


    public function updateSubscription(Student $student, array $attributes = []): ?Subscription
    {
        if (!$sub = $this->findSubscription($student))
            return null;

        $sub->fill($attributes);
        $sub->save();

        return $sub;
    }
}
