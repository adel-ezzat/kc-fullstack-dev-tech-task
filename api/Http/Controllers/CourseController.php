<?php

declare(strict_types=1);

namespace Http\Controllers;

use Core\Http\JsonResponse;
use Models\CourseRepository;

/**
 * Course controller
 */
class CourseController
{
    /**
     * @var JsonResponse
     */
    private JsonResponse $jsonResponse;
    /**
     * @var CourseRepository
     */
    private CourseRepository $courseRepository;


    public function __construct()
    {
        $this->jsonResponse = new JsonResponse();
        $this->courseRepository = new CourseRepository();
    }

    /**
     * Get all courses.
     *
     * @return void
     */
    public function index(): void
    {
        $courses = $this->courseRepository->getAll();

        echo $this->jsonResponse->response(200, $courses);
    }

    /**
     * Get courses by category id
     *
     * @param $request
     * @return void
     */
    public function showById($request): void
    {
        $course = $this->courseRepository->findById($request['id']);

        echo $this->jsonResponse->response(200, $course);
    }

    /**
     * get category tree
     * @param $request
     * @return void
     */
    public function getCategoryCourses($request): void
    {
        $courses = $this->courseRepository->getCategoryCourses($request['id']);

        echo $this->jsonResponse->response(200, $courses);
    }
}