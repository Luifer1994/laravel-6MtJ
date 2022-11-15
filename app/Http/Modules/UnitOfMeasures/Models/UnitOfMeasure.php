<?php

/**
 * Created by Reliese Model.
 */

namespace App\Http\Modules\UnitOfMeasures\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UnitOfMeasure
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property string|null $code
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Inventory[] $inventories
 * @property Collection|ProductPlate[] $product_plates
 * @property Collection|Product[] $products
 *
 * @package App\Http\Modules
 */
class UnitOfMeasure extends Model
{
	use SoftDeletes;
	protected $table = 'unit_of_measures';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'is_active',
		'code'
	];

	public function inventories()
	{
		return $this->hasMany(Inventory::class);
	}

	public function product_plates()
	{
		return $this->hasMany(ProductPlate::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
