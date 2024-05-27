<?php

declare(strict_types=1);

namespace App\Traits;

use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;

trait UserTimeZoneAware
{
    /**
     * The attribute name containing the timezone (defaults to "timezone").
     */
    public string $timezoneAttribute = 'timezone';

    /**
     * Return the passed date in the user's timezone (or default to the app timezone).
     *
     * @throws Exception
     */
    public function getAttributes(): array
    {
        foreach ($this->attributes as $key => $attribute) {
            if (str_ends_with($key, '_at') && $this->isValidDateTime($attribute)) {
                $this->attributes[$key] = $this->getDateToUserTimezone($attribute);
            }
        }

        return $this->attributes;
    }

    /**
     * Determine if DateTime is Valid
     */
    private function isValidDateTime($date, string $format = 'Y-m-d H:i:s'): ?bool
    {
        if (empty($date)) {
            return null;
        }

        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    /**
     * Change a DateTime to use User Timezone
     *
     * @param null $timezone
     *
     * @throws Exception
     */
    public function getDateToUserTimezone($date, $timezone = null): string|null
    {
        if (empty($date)) {
            return null;
        }

        if ($timezone == null) {
            if (Auth::check()) {
                $timezone = Auth::user()->timezone ?? config('app.timezone');
                //in some weird scenarios, the timezone might be empty for the user, we wanna handle that too.
            } else {
                //should find agency timezone somewhere in here for community sites...
                $timezone = config('app.timezone');
            }
        }
        $datetime = new \DateTime($date);
        $datetime->setTimezone(new \datetimezone($timezone));

        return $datetime->format('c');
    }
}
