<?php

namespace App\Services\Contracts;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;

interface NewsManagerInterface
{
    function getAllCategories() : Collection;

    function getAll($categoryId = null,
                    $newsTitle = null,
                    $regsByPage = 5,
                    $page = 1) : array;

    function findByCode(string $code) : ?News;

    function create(array $payload) : News;

    function update(News $news, array $payload) : bool;

    function delete(string $code) : bool;
}
