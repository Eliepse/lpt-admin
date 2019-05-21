<?php

namespace App\Traits;


use Illuminate\Support\Str;

trait HasHumanNames
{
    public function getFullname($last_first = false): string
    {
        if ($last_first)
            return $this->lastname . ' ' . $this->firstname;
        else
            return $this->firstname . ' ' . $this->lastname;
    }


    public function getInitials(): string
    {
        return Str::upper(Str::substr($this->firstname, 0, 1) .
            Str::substr($this->lastname, 0, 1));
    }
}