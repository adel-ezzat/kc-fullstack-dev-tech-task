<?php

declare(strict_types=1);

namespace Models;

use Core\Model\Model;

/**
 * Category repository
 */
class CategoryRepository extends Model implements CategoryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    /**
     * Common SELECT query for categories with optional conditions.
     *
     * @param array $bindings
     * @return array
     */
    private function buildQuery(array $bindings = []): array
    {
        $query = "
          WITH category_cte AS (SELECT c.*
            ,(
                    WITH RECURSIVE hierarchy_categories AS (
                        SELECT id
                        FROM categories
                        WHERE id = c.id
                        UNION ALL
                        SELECT c.id
                        FROM categories c
                        INNER JOIN hierarchy_categories hc ON c.parent_id = hc.id
                    )
                    SELECT COUNT(*)
                    FROM courses
                    WHERE courses.category_id IN (
                        SELECT id
                        FROM hierarchy_categories
                    )
                ) AS count_of_courses
                ,(
                    WITH RECURSIVE category_level AS (
                        SELECT 
                            id,
                            parent_id,
                            1 AS lvl
                        FROM categories
                        WHERE id = c.id
                        UNION
                        SELECT 
                            c.id,
                            c.parent_id,
                            lvl + 1 AS lvl
                        FROM categories c
                        JOIN category_level cl ON cl.parent_id = c.id
                    )
                    SELECT MAX(lvl)
                    FROM category_level
                ) AS level
            FROM categories c)
            SELECT 
                id,
                name,
                parent_id,
                count_of_courses,
                created_at,
                updated_at
            FROM category_cte 
            where level <= 4
        ";

        if ($bindings) {
            $query .= ' AND id = ?';
        }

        return $this->rawQuery($query, $bindings);
    }

    /**
     * Get all categories with their courses count.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->buildQuery();
    }

    /**
     * Find a category by its ID with its course count.
     *
     * @param int $id
     * @return array
     */
    public function findById($id): array
    {
        return $this->buildQuery([$id]);
    }
}
