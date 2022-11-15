<?php

/**
 * Created by Reliese Model.
 */

namespace App\Http\Modules\DocumentTypes\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DocumentType
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Http\Modules
 */
class DocumentType extends Model
{
	use SoftDeletes;
	protected $table = 'document_types';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'code',
		'is_active'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
