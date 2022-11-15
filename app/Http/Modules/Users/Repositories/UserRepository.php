<?php

namespace App\Http\Modules\Users\Repositories;

use App\Http\Modules\Bases\BaseRepository;
use App\Http\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    protected $model;
    function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    /**
     * Funtion to get user for email for login.
     *
     * @return User
     * @param string $email
     */
    public function getByEmailForLogin(string $email): User
    {
        return $this->model->select('id', 'name', 'last_name', 'email', 'password')
            /* ->with(['roles']) */
            ->where(['email' => $email, 'is_active' => true, 'type' => 'employee'])->first();
    }

    /**
     * Funtion to list user paginates.
     *
     * @return User
     * @param string $search, int $limit
     */
    public function listPaginate(string $search, int $limit): object
    {
        return $this->model->select('id', 'name', 'last_name', 'email', 'type', 'is_active', 'document_type_id', 'document_number', 'phone')
            ->with(['document_type:id,name'])
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('type', 'like', '%' . $search . '%')
            ->orWhere('document_number', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->paginate($limit);
    }
}
