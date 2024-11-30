<?php

declare(strict_types=1);

namespace Http\Controllers;

use Core\Http\JsonResponse;
use Models\CategoryRepository;

/**
 * Category controller
 */
class CategoryController
{
    /**
     * @var JsonResponse
     */
    private JsonResponse $jsonResponse;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->jsonResponse = new JsonResponse();
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * Get all categories with their courses count.
     *
     * @return void
     */
    public function index(): void
    {
        $categories = $this->categoryRepository->getAll();

        echo $this->jsonResponse->response(200, $categories);
    }

    /**
     * Find a category by its ID with its course count.
     *
     * @param $request
     * @return void
     */
    public function showById($request): void
    {
        $category = $this->categoryRepository->findById($request['id']);

        echo $this->jsonResponse->response(200, $category);
    }

    /**
     *  get category tre
     * @param $request
     * @return void
     */
    public function tree($request): void
    {
        $categoryData = $this->categoryRepository->getAll();
        $categoryTree = $this->buildCategoryTree($categoryData);

        echo $this->jsonResponse->response(200, $categoryTree);
    }

    /**
     * build category tree
     *
     * @param $categories
     * @param $parentId
     * @return array
     */
    public function buildCategoryTree($categories, $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] === $parentId) {
                $children = $this->buildCategoryTree($categories, $category['id']);

                $tree[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'parent_id' => $category['parent_id'],
                    'count_of_courses' => $category['count_of_courses'],
                    'children' => $children,
                ];
            }
        }

        return $tree;
    }
}