<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait WithUUID
{
    /**
     * Boot method for WithUUID Trait
     */
    public static function bootWithUUID(): void
    {
        static::creating(function (Model $model) {
            $model->setKeyType('string');
            $model->setIncrementing(false);
            $model->setAttribute($model->getKeyName(), Str::uuid());
            $model->setAttribute('id', Str::uuid());
        });
    }

    /**
     * Get Incrementing setting
     *
     * @return false
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the Key Type setting
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Get Short ID Attribute
     *
     * @return false|string
     */
    public function getShortIdAttribute(): bool|string
    {
        $idArray = explode('-', $this->id);

        return $this->short_id = end($idArray);
    }
}
