<?php

namespace App\Http\Modules\Users\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Users\Models\User;
use App\Http\Modules\Users\Services\UserService;
use App\Http\Modules\Users\Requests\LoginRequest;
use App\Http\Modules\Users\Requests\CreateUserRequest;
use App\Http\Modules\Users\Requests\UpdateUserRequest;
use App\Http\Modules\Users\Repositories\UserRepository;
use App\Http\Modules\Users\Requests\AsingRoleUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $UserService;
    protected $UserRepository;

    public function __construct(UserService $UserService, UserRepository $UserRepository)
    {
        $this->UserService    = $UserService;
        $this->UserRepository = $UserRepository;
    }

    /**
     * Funtion to login.
     *
     * @return ResponseJson
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $login = $this->UserService->login($request);
            return response()->json(['message' => $login['message'], 'res' => $login['res'], 'data' => $login['data']], $login['code']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to logout.
     *
     * @return ResponseJson
     */
    public function logout(): JsonResponse
    {
        try {
            $logout = $this->UserService->logout();
            return response()->json(['message' => $logout['message'], 'res' => $logout['res'], 'data' => $logout['data']], $logout['code']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to create user.
     *
     * @return JsonResponse
     * @param CreateUserRequest $request
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $create = $this->UserService->create($request);

            return response()->json(['message' => $create['message'], 'res' => $create['res'], 'data' => $create['data']], $create['code']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to update user.
     *
     * @return JsonResponse
     * @param UpdateUserRequest $request
     */
    public function update(UpdateUserRequest $request, int $id) //: JsonResponse
    {
        try {
            $user   = $this->UserRepository->find($id);
            if ($user) {
                $update = $this->UserRepository->update($user, $request);
                return response()->json(['message' => 'Usuario actualizado correctamente', 'res' => true, 'data' => $update], Response::HTTP_CREATED);
            } else {
                return response()->json(['message' => 'Usuario no encontrado', 'res' => false, 'data' => null], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to filter user.
     *
     * @return JsonResponse
     * @param int $id
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->UserRepository->find($id);
            if ($user) {
                return response()->json(['message' => 'Usuario encontrado', 'res' => true, 'data' => $user], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Usuario no encontrado', 'res' => false, 'data' => null], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to list user paginates.
     *
     * @return JsonResponse
     * @param Request $request
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $limit  = $request->limit   ?? 10;
            $search = $request->search  ?? "";
            $users  = $this->UserRepository->listPaginate($search, $limit);

            return response()->json(['message' => 'Usuarios encontrados', 'res' => true, 'data' => $users], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to delete user.
     *
     * @return JsonResponse
     * @param int $id
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $user = $this->UserRepository->find($id);
            if ($user) {
                $this->UserRepository->delete($user);
                return response()->json(['message' => 'Usuario eliminado correctamente', 'res' => true, 'data' => null], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Usuario no encontrado', 'res' => false, 'data' => null], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to asing role to user.
     *
     * @return JsonResponse
     * @param AsingRoleUserRequest $request
     */
    public function asingRole(AsingRoleUserRequest $request): JsonResponse
    {
        try {
            $user = $this->UserRepository->find($request->user_id);
            if ($user) {
                $user->assignRole($request->role);
                return response()->json(['message' => 'Rol asignado correctamente', 'res' => true, 'data' => $user], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Usuario no encontrado', 'res' => false, 'data' => null], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => null], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Funtion to validate authentication.
     *
     * @return JsonResponse
     * @param AsingRoleUserRequest $request
     */
    public function validateAuth(): JsonResponse
    {
        try {
            return response()->json(Auth::check(), Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'res' => false, 'data' => false], Response::HTTP_UNAUTHORIZED);
        }
    }
}
