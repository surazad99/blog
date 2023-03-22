<?php

namespace App\Services;

use App\Models\Blog;
use Exception;

class BlogService
{
    public function getAllBlogs()
    {
        return Blog::latest()->paginate(PAGINATE);
    }

    public function findById($blogId)
    {
        $blog = Blog::find($blogId);
        if(!$blog){
            throw new Exception('No such resource found', 404);
        }
        return $blog;
    }

    public function storeBlog(array $validatedBlog)
    {
        if(isset($validatedBlog['image'])){
            $validatedBlog['image'] = storeImage($validatedBlog['image'], BLOG_IMAGE_URL);
        }
        Blog::create($validatedBlog);
    }

    public function updateBlog(array $validatedBlog, Blog $blog)
    {
        if(isset($validatedBlog['image'])){
            deleteImage($blog->image, BLOG_IMAGE_URL);
            $validatedBlog['image'] = storeImage($validatedBlog['image'], BLOG_IMAGE_URL);
        }

        $blog->update($validatedBlog);
    }

    public function deleteBlog(Blog $blog)
    {
        deleteImage($blog->image, BLOG_IMAGE_URL);
        $blog->delete();
    }
}