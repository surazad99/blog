<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogCreateRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Services\BlogService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    protected $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = $this->blogService->getAllBlogs();
        return BlogResource::collection($blogs);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $blogCreateRequest)
    {
        $validatedBlog = $blogCreateRequest->validated();
        try{
            DB::beginTransaction();
            $this->blogService->storeBlog($validatedBlog);
            DB::commit();
            return response()->json(['message' => 'Blog Created Successfully'], 201);

        }catch(Exception $exception){
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $blog = $this->blogService->findById($id);
            return new BlogResource($blog);

        }catch(Exception $exception){
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $blogUpdateRequest, string $id)
    {
        $validatedBlog = $blogUpdateRequest->validated();
        try{
            DB::beginTransaction();
            $blog = $this->blogService->findById($id);
            $this->blogService->updateBlog($validatedBlog, $blog);
            DB::commit();
            return response()->json(['message' => 'Blog Updated Successfully'], 201);

        }catch(Exception $exception){
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            $blog = $this->blogService->findById($id);
            $this->blogService->deleteBlog($blog);
            DB::commit();
            return response()->json(['message' => 'Blog Deleted Successfully'], 200);

        }catch(Exception $exception){
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
