<?php

namespace Support\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /** @param self|int|string $model */
    public static function findBy($model): ?self
    {
        if ($model instanceof static) {
            return $model;
        }

        if (is_int($model)) {
            return static::find($model);
        }

        if (is_string($model)) {
            return static::where((new static())->getRouteKeyName(), $model)->firstOrFail();
        }

        return null;
    }
}
