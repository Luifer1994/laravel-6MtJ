<?php

/**
 * Created by Reliese Model.
 */

namespace App\Http\Modules\Categories\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property string $type
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Plate[] $plates
 * @property Collection|Product[] $products
 *
 * @package App\Http\Modules
 */
class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
	use SoftDeletes;
	protected $table = 'categories';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'image',
		'type',
		'is_active'
	];

	public function plates()
	{
		return $this->hasMany(Plate::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
