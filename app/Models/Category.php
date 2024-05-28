<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 * @method static CategoryFactory factory($count = null, $state = [])
 * @method static Builder|Category hasProducts()
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category active()
 * @method static Builder|Category conditionalOrderBy(string $orderByField, string $directionValue)
 * @method static Builder|Category testing()
 * @mixin Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeConditionalOrderBy(Builder $query, string $orderByField, string $directionValue): void
    {

        $query->orderBy($orderByField, $directionValue);

    }

    public function scopeTesting(Builder $query): void
    {
        $query->where('id', '=', '25');
    }

    public function scopeHasProducts(Builder $query): void
    {
        $query->products();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query): void
    {
         $query->where('status', 'active');
    }


//    protected function casts(): array
//    {
//        return [
//            'id' => 'bool'
//        ];
//    }

}
