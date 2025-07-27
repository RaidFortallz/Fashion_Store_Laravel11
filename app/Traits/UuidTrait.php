<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    /**
     * Boot the UUID trait for the model.
     */
    protected static function bootUuidTrait()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->incrementing = false;
                $model->keyType = 'string';
                $model->{$model->getKeyName()} = (string) Str::orderedUuid();
            }
        });
    }

    /**
     * UUID is non-incrementing.
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * UUID key type is string.
     */
    public function getKeyType()
    {
        return 'string';
    }
}
