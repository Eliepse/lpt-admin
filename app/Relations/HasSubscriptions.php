<?php


namespace App\Relations;


use App\Subscription;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSubscriptions
{
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }


    public function subscribeTo(HasSubscribers $marketable)
    {
        $marketable->subscribe($this);
    }
}
