<?php

namespace App\Http\Modules\Categories\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Categories\Models\Category;
use App\Http\Modules\Categories\Repositories\CategoryRepository;
use App\Http\Modules\Categories\Requests\CreateCategoryRequest;
use App\Http\Modules\Categories\Requests\PaginateCategoryRequest;
use App\Http\Modules\Categories\Requests\UpdateCategoryRequest;
use App\Http\Modules\Categories\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $CategoryService;
    protected $CategoryRepository;

    public function __construct(CategoryService $CategoryService, CategoryRepository $CategoryRepository)
    {
        $this->CategoryService    = $CategoryService;
        $this->CategoryRepository = $CategoryRepository;
    }

    /**
     * Function to create a new Category
     *
     * @return \Illuminate\Http\JsonResponse
     * @param CreateCategoryRequest $request
     */
    public function store(CreateCategoryRequest $request): JsonResponse
    {
        try {
            $category = new Category($request->all());
            return response()->json(['message' => 'Categoria creada con exito', 'data' => $this->CategoryRepository->save($category)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Function to update a Category
     *
     * @return \Illuminate\Http\JsonResponse
     * @param UpdateCategoryRequest $request
     * @param int $id
     */
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = $this->CategoryRepository->find($id);
            if ($category) {
                return response()->json(['message' => 'Categoria actualizada con exito', 'data' => $this->CategoryRepository->update($category, $request)], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Categoria no encontrada'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Function to delete a Category
     *
     * @return \Illuminate\Http\JsonResponse
     * @param int $id
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $category = $this->CategoryRepository->find($id);
            if ($category) {
                $this->CategoryRepository->delete($category);
                return response()->json(['message' => 'Categoria eliminada con exito'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Categoria no encontrada'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Function to get all Categories paginated.
     *
     * @return \Illuminate\Http\JsonResponse
     * @param Request $request
     */
    public function index(PaginateCategoryRequest $request)//: JsonResponse
    {
        try {
            $limit  = $request->limit   ?? 10;
            $search = $request->search  ?? "";
            $active = $request->state   ?? "";

            $categories = $this->CategoryRepository->paginate($limit, $search, $active);

            return response()->json(['message' => 'Ok', 'data' => $categories], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Function to get a Category by id.
     *
     * @return \Illuminate\Http\JsonResponse
     * @param int $id
     */
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->CategoryRepository->find($id);
            if ($category) {
                return response()->json(['message' => 'Ok', 'data' => $category], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Categoria no encontrada'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
