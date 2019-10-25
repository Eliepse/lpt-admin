<?php

namespace App\Traits;


use Illuminate\Support\Str;

/**
 * Trait HasHumanNames
 * @package App\Traits
 * @property bool $withChineseNames
 * @property string $firstname
 * @property string $lastname
 * @property string|null $firstname_zh
 * @property string|null $lastname_zh
 */
trait HasHumanNames
{
    public function getFullname($last_first = false): string
    {
        if ($last_first) {
            return $this->lastname . ' ' . $this->firstname;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }

    public function getInitials(): string
    {
        return Str::upper(Str::substr($this->firstname, 0, 1) .
            Str::substr($this->lastname, 0, 1));
    }

    private function getFirstnameZh(): string
    {
        if (!$this->hasChineseNames()) {
            return $this->firstname;
        }

        $firstname = $this->attributes['firstname_zh'] ?? null;
        return !empty($firstname) ? $firstname : $this->firstname;
    }

    private function getLastnameZh(): string
    {
        if (!$this->hasChineseNames()) {
            return $this->lastname;
        }

        $lastname = $this->attributes['lastname_zh'] ?? null;
        return !empty($lastname) ? $lastname : $this->lastname;
    }

    public function getFullnameZh($last_first = false): string
    {
        if (!$this->hasChineseNames()) {
            return $this->getFullname($last_first);
        }

        if ($last_first) {
            return $this->getLastnameZh() . ' ' . $this->getFirstnameZh();
        } else {
            return $this->getFirstnameZh() . ' ' . $this->getLastnameZh();
        }
    }

    public function hasChineseNames(): bool
    {
        if (!$this->withChineseNames) {
            return false;
        }

        return !empty($this->attributes['firstname_zh']) || !empty($this->attributes['lastname_zh']);
    }
}