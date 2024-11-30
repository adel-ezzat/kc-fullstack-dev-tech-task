<?php

declare(strict_types=1);

namespace Models;

/**
 * Category repository interface
 */
interface CategoryRepositoryInterface
{
    /**
     * Get all categories with their courses count.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Find a category by its ID with its course count.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id);
}