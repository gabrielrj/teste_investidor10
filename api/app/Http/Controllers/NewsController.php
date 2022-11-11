<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsPostAndPutRequest;
use App\Http\Resources\AllNewsResource;
use App\Http\Resources\NewsForUpdateResource;
use App\Services\Contracts\NewsManagerInterface;
use App\Services\Contracts\UserManagerInterface;
use Illuminate\Support\Arr;

class NewsController extends Controller
{
    use CallableIntercept;

    protected NewsManagerInterface $newsManagerService;

    public function __construct(NewsManagerInterface $newsManagerService)
    {
        $this->newsManagerService = $newsManagerService;
    }

    public function getAllCategories(): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () {
            return[
                'categories' => $this->newsManagerService->getAllCategories()
            ];
        });
    }

    public function getAllNews($categoryId = null,
                                $newsTitle = null,
                                $regsByPage = 5,
                                $page = 1): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () use($categoryId, $newsTitle, $regsByPage, $page){
            $result = $this->newsManagerService->getAll($categoryId, $newsTitle, $regsByPage, $page);

            $news = AllNewsResource::collection(Arr::get($result, 'news'));

            $result = Arr::set($result, 'news', $news);

            return[
                'result' => $result
            ];
        });
    }

    public function findNewsByCode($code): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () use($code){
            return [
                'news' => new NewsForUpdateResource($this->newsManagerService->findByCode($code))
            ];
        });
    }

    public function createNewNews(NewsPostAndPutRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () use($request){
            $payload = $request->validated();

            return [
                'news' => $this->newsManagerService->create($payload)
            ];
        });
    }

    public function updateNews(NewsPostAndPutRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () use($request, $id){
            $news = $this->newsManagerService->findByCode($id);

            $payload = $request->validated();

            return [
                'updated' => $this->newsManagerService->update($news, $payload)
            ];
        });
    }

    public function deleteNews($id): \Illuminate\Http\JsonResponse
    {
        return $this->run(function () use($id){
            return [
                'deleted' => $this->newsManagerService->delete($id)
            ];
        });
    }
}
