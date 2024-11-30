<?php

declare(strict_types=1);

namespace Models;

use Core\Model\Model;

/**
 * Course repository
 */
class CourseRepository extends Model implements CourseRepositoryInterface
{

    public const string FIND_BY_ID = 'FIND_BY_ID';
    public const string GET_COURSES_BY_CATEGORY_ID = 'GET_COURSES_BY_CATEGORY_ID';

    public function __construct()
    {
        parent::__construct('courses');
    }

    /**
     * Get all courses.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->buildQuery();
    }

    /**
     * Common SELECT query for courses with optional conditions.
     *
     * @param array $bindings
     * @param string|null $type
     * @return array
     */
    private function buildQuery(array $bindings = [], string $type = null): array
    {
        $query = "";
        if ($type == self::GET_COURSES_BY_CATEGORY_ID) {
            $query .= "
                  WITH RECURSIVE filter_courses AS (
                    SELECT id
                    FROM categories
                    WHERE id = ?
                    UNION ALL
                    SELECT c.id
                    FROM categories c
                    INNER JOIN filter_courses fc ON c.parent_id = fc.id
                )
            ";
        }

        $query .= "
            SELECT 
                id, 
                name,
                description,
                preview,
                (
                    SELECT name
                    FROM (
                        WITH RECURSIVE category_main_name AS (
                            SELECT 
                                id,
                                parent_id,
                                name 
                            FROM categories
                            WHERE id = courses.category_id
                            UNION ALL
                            SELECT 
                                c.id,
                                c.parent_id,
                                c.name 
                            FROM categories c
                            JOIN category_main_name cma ON c.id = cma.parent_id
                        ) 
                        SELECT name FROM category_main_name
                        ORDER BY id
                        LIMIT 1
                    ) AS recursive_query
                ) AS main_category_name,
                created_at,
                updated_at
            FROM courses
        ";

        $query .= match ($type) {
            self::FIND_BY_ID => 'WHERE id = ?',
            self::GET_COURSES_BY_CATEGORY_ID => 'WHERE courses.category_id IN (SELECT id FROM filter_courses)',
            default => ''
        };

        return $this->rawQuery($query, $bindings);
    }

    /**
     * Find a course by its ID.
     *
     * @param int $id
     * @return array
     */
    public function findById($id): array
    {
        return $this->buildQuery([$id], self::FIND_BY_ID);
    }

    /**
     * Get courses by category id
     * @param $id
     * @return array
     */
    public function getCategoryCourses($id): array
    {
        return $this->buildQuery([$id], self::GET_COURSES_BY_CATEGORY_ID);
    }
}