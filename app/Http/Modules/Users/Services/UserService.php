<?php

namespace App\Http\Modules\Users\Services;

use App\Http\Modules\Users\Models\User;
use App\Http\Modules\Users\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected   $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * Funtion to login.
     *
     * @return array
     * @param Request $request
     */
    public function login(Request $request): array
    {
        $user = $this->UserRepository->getByEmailForLogin($request->email);

        if ($user && Hash::check($request->password, $user->password)) {

            $user->getPermissionsViaRoles();
            $roles       = collect($user->getRoleNames());
            $permissions = collect($user->getAllPermissions());
            $permissions = collect($permissions)->pluck('name')->flatten()->toArray();

            $userLogged = collect([
                'id'          => $user->id,
                'name'        => $user->name . ' ' . $user->last_name,
                'email'       => $user->email,
                'roles'       => base64_encode(json_encode($roles)),
                'permissions' => base64_encode(json_encode($permissions)),
            ]);
            return [
                'res'     => true,
                'data'    => ['token' => $user->createToken('ADMIN_RESTAURANT')->plainTextToken, 'user' => $userLogged],
                'message' => 'Bienvenido al sistema',
                'code'    => Response::HTTP_OK
            ];
        } else {
            return [
                'res'     => false,
                'message' => 'Email o password incorrecto',
                'code'    => Response::HTTP_UNAUTHORIZED,
                'data'    => null
            ];
        }
    }

    /**
     * Funtion to logout.
     *
     * @return array
     */
    public function logout(): array
    {
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });
        return [
            'res' => true,
            'message' => 'Sesión cerrada correctamente',
            'code' => Response::HTTP_OK,
            'data' => null
        ];
    }

    /**
     * Funtion to create user.
     *
     * @return array
     * @param Request $request
     */
    public function create(Request $request): array
    {
        $request["password"] = $request["password"] ? bcrypt($request["password"]) : null;
        $user                = new User($request->all());
        $user                = $this->UserRepository->save($user);
        if ($user) {
            return [
                'res'     => true,
                'message' => 'Usuario creado correctamente',
                'code'    => Response::HTTP_CREATED,
                'data'    => $user
            ];
        } else {
            return [
                'res'     => false,
                'message' => 'Error al crear usuario',
                'code'    => Response::HTTP_BAD_REQUEST,
                'data'    => null
            ];
        }
    }
}
