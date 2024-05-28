<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $category_id
 * @property int $isActive
 * @property string $name
 * @property string $price
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $category
 * @method static Builder|Product active()
 * @method static ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product inStock()
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsActive($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @property-read \App\Models\Supplier|null $supplier
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeInStock(Builder $query): void
    {
        $query->where('quantity', '>', 0);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    //relations
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    //model methods

//    public function isActive(): bool
//    {
//        return $this->isActive;
//    }

    //scopes
    public function scopeActive(
        Builder $query
    ): void {
        $query->where('isActive', true);
    }


    protected function casts(): array
    {
        return [
            'isActive' => 'bool',
        ];
    }
}
