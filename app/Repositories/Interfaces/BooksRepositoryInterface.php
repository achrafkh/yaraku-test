<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface BooksRepositoryInterface extends BaseRepositoryInterface
{
    public function exportData(array $sort, $keyword = null, $cols = '*');
}
