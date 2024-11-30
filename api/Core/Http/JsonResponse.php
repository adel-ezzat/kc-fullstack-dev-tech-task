<?php

declare(strict_types=1);

namespace Core\Http;

/**
 * HTTP JSON response
 */
class JsonResponse
{
    /**
     * encode attributes and return json
     *
     * @param int $responseCode
     * @param array|null $attributes
     * @return false|string
     */
    public function response(int $responseCode, array $attributes = null): false|string
    {
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        http_response_code($responseCode);

        return json_encode($attributes);
    }
}