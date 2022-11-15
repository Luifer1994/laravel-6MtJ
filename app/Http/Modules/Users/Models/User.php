<?php

/**
 * Created by Reliese Model.
 */

namespace App\Http\Modules\Users\Models;

use App\Http\Modules\DocumentTypes\Models\DocumentType;
use App\Http\Modules\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string $document_number
 * @property int $document_type_id
 * @property string $type
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property DocumentType $document_type
 * @property Collection|Product[] $products
 *
 * @package App\Http\Modules
 */
class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes, HasApiTokens, Notifiable, HasFactory, HasRoles;

    protected $table = 'users';

    protected $casts = [
        'document_type_id' => 'int',
        'is_active' => 'bool'
    ];

    protected $dates = [
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'document_number',
        'document_type_id',
        'type',
        'email_verified_at',
        'password',
        'is_active',
        'remember_token'
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
