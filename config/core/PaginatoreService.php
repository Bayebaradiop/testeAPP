<?php

namespace App\Core;

class PaginatoreService
{
    private static ?PaginatoreService $instance = null;

    public static function getInstance(): PaginatoreService
    {
        if (self::$instance === null) {
            self::$instance = new PaginatoreService();
        }
        return self::$instance;
    }

    public function paginate(array $data, int $currentPage, int $perPage): array
    {
        $totalItems = count($data);
        $totalPages = ceil($totalItems / $perPage);

        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $perPage;

        return [
            'data' => array_slice($data, $offset, $perPage),
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'total_items' => $totalItems,
        ];
    }
}
