<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Types;
use App\Traits\Uuids;
use App\Traits\Loggable;
use App\Traits\QueryFormatter;
use App\Traits\UserTimeZoneAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static static create(array $attributes = [])
 * @method static static firstOrCreate(array $attributes, array $values = [])
 * @method static static firstOrNew(array $attributes, array $values = [])
 * @method static static firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static updateOrCreate(array $attributes, array $values = [])
 *
 * @mixin Builder
 */
class BaseModel extends Model
{
    use HasFactory;
    use Loggable;
    use UserTimeZoneAware;
    use QueryFormatter;

    use Uuids;
    use Types;
    use HasFactory;

    protected $guarded = ['id'];
    protected array $loggable = ['*'];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function phone(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => formatPhoneNumber($value)
        );
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
    //    public function getUpdatedAtAttribute($value): string
    //    {
    ////        return Carbon::parse($value)->diffForHumans();
    //    }
}
