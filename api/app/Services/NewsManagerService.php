<?php

namespace App\Services;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\ArrayShape;

class NewsManagerService implements Contracts\NewsManagerInterface
{
    function getAllCategories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }

    #[ArrayShape(['totalPages' => "int", 'currentPage' => "int|mixed", 'totalRegs' => "int", 'news' => "\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection"])]
    function getAll($categoryId = null,
                    $newsTitle = null,
                    $regsByPage = 5,
                    $page = 1): array
    {
        $query = News::query()->with('category')->orderByDesc('created_at');

        if($categoryId && $categoryId != 'null' && $categoryId != 0)
            $query->where('categories_id', '=', $categoryId);

        if($newsTitle && $newsTitle != 'null')
            $query->where('title', 'like', "%$newsTitle%");

        $paginador = $query->paginate($regsByPage);

        $totalPages = $paginador->lastPage();

        $totalRegs = $paginador->total();

        if($page > $totalPages)
            $page = $totalPages;

        return [
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'totalRegs' => $totalRegs,
            'news' => $query->forPage($page, $regsByPage)->get()
        ];
    }

    function findByCode(string $code): ?News
    {
        return News::query()->with('category')->whereCode($code)->first();
    }

    function create(array $payload): News
    {
        $news = new News();

        $news->title = $payload['title'];
        $news->body = $payload['body'];
        $news->categories_id = $payload['categories_id'];
        $news->save();

        return $news;
    }

    function update(News $news, array $payload): bool
    {
        return $news->update($payload);
    }

    /**
     * @throws \Throwable
     */
    function delete(string $code): bool
    {
        $news = $this->findByCode($code);

        throw_if(!$news, new \Exception('News not found!'));

        return $news->delete();
    }
}
