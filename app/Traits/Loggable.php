<?php

declare(strict_types=1);

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait Loggable
{
    use LogsActivity;

    /**
     * Get the Model that is being logged
     */
    private static function loggedModel(): null|static
    {
        $class = get_called_class();

        if ($class) {
            return new $class();
        }

        return new self();
    }

    /**
     * Set the activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        $classArray = explode('\\', get_class($this));
        $className = end($classArray);
        $logOptions = LogOptions::defaults()
            ->useLogName($className)
            ->setDescriptionForEvent(fn(string $eventName) => $className.' '.$eventName);
        if ($this->loggable) {
            $logOptions->logOnly($this->loggable);
        } else {
            $logOptions->logFillable();
        }
        $logOptions->logOnlyDirty();

        return $logOptions;
    }

    public function getEncryptedPropeties(): array
    {
        $encryptedKeys = [];
        if (isset($this->casts)) {
            foreach ($this->casts as $key => $value) {
                if (str_contains(strtolower($value), 'encrypted')) {
                    $encryptedKeys = [...$encryptedKeys, strtolower($key)];
                }
            }
        }

        return $encryptedKeys;
    }
}
