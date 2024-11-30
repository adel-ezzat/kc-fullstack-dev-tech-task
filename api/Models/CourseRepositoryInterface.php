<?php

declare(strict_types=1);

namespace Models;

/**
 * course repository interface
 */
interface CourseRepositoryInterface
{
    /**
     * Get all courses.
     *
     * @return mixed
     */
    public function getAll(): mixed;

    /**
     * Find a course by its ID.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id): mixed;

    /**
     * Get courses by category id
     *
     * @param $id
     * @return mixed
     */
    public function getCategoryCourses($id): mixed;
}