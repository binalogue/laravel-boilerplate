<?php

namespace Support\SchemalessAttributes;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;

trait HasExtraAttributes
{
    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasExtraAttributes()
    {
        self::saving(function ($model) {
            $model->cleanExtraAttributes('extra_attributes', false);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Get the model's "extra_attributes" attribute.
     *
     * @return \Spatie\SchemalessAttributes\SchemalessAttributes
     */
    public function getExtraAttributesAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'extra_attributes');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include models with "extra_attributes" attribute.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithExtraAttributes(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('extra_attributes');
    }

    /*
    |--------------------------------------------------------------------------
    | Business
    |--------------------------------------------------------------------------
    */

    /**
     * Remove empty attributes from the given field.
     *
     * @param  string  $attribute
     * @param  bool  $persist
     * @return \Domain\Users\Models\User
     */
    public function cleanExtraAttributes(
        string $attribute,
        bool $persist = true
    ): self {
        if (!is_array($this->{$attribute}->all())) {
            return $this;
        }

        $this->{$attribute} = collect($this->{$attribute}->all())
            ->reject(function ($value) {
                return is_null($value);
            })
            ->toArray();

        if ($persist) {
            $this->save();
        }

        return $this;
    }
}
