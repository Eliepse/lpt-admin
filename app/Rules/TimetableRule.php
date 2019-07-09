<?php

namespace App\Rules;

use App\Enums\DaysEnum;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class TimetableRule implements Rule
{
    /** @var bool $multiple */
    private $multiple;
    private $error_msg = ':name as an invalid selection.';


    /**
     * Create a new rule instance.
     *
     * @param bool $allow_multiple
     */
    public function __construct(bool $allow_multiple = true)
    {
        $this->multiple = $allow_multiple;
        // TODO check if empty and add "allow_empty"
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $timetable = json_decode($value, true);

        // Check multiple days
        // TODO to change because some days can be empty
//        if (!$this->multiple && count($timetable) > 1)
//            return false;

        // Check if days are valid
        foreach ($timetable as $day => $hours) {

            // Check multiple hours
            if (!$this->multiple && count($timetable[0]) > 1) {
                $this->error_msg = 'Only one choice allowed.';

                return false;
            }

            // Check if day is valid
            if (!DaysEnum::hasKey($day)) {
                $this->error_msg = "The day '$day' does not exist.";

                return false;
            }

            // Check if hours are valid
            foreach ($hours as $hour) {
                if (!Carbon::hasFormat($hour, "H:i")) {
                    $this->error_msg = 'This hour is not in the right format.';

                    return false;
                }
            }

            // TODO check for duplicates
            // TODO maybe use a middleware to clean schedules
        }

        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error_msg;
    }
}
