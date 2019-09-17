<?php


namespace App\Relations;


use App\Student;
use App\Subscription;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface Marketable
{
    public function subscriptions(): MorphMany;


    public function getPrice(): int;


    public function subscribe(Student $student): Subscription;


    public function students(): Collection;
}
