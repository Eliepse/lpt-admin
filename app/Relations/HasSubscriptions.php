<?php


namespace App\Relations;


use App\Subscription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait HasSubscriptions
 *
 * @package App\Relations
 * @property Collection $subscriptions
 */
trait HasSubscriptions
{
    /**
     * Return the query for this model subscriptions
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }


    /**
     * Subscribe the model to the given model
     *
     * @param Model|HasSubscribers $model
     */
    public function subscribeTo(Model $model)
    {
        $model->subscribe($this);
    }


    /**
     * Find the subscription between this model and the given one
     *
     * @param Model|HasSubscribers $model
     *
     * @return Subscription|null Return the subscription, null otherwise.
     */
    public function findSubscription(Model $model): ?Subscription
    {
        return $this->subscriptions->first(function (Subscription $subscription) use ($model) {
            return optional($subscription->marketable)->is($model);
        });
    }
}
