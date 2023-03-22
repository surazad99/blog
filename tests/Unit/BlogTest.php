<?php

namespace Tests\Unit;

use App\Models\Blog;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /** @test */
    public function it_can_create_a_blog()
    {
        $faker = Factory::create();

        $data = [
            'title' => $faker->sentence(),
            'description' => $faker->paragraph(),
            'image' => UploadedFile::fake()->image('image' . time() . '.png', 640, 480),
        ];
        $this->json('POST', 'api/blogs', $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "message" => "Blog Created Successfully",
            ]);
    }

    public function it_can_show_a_blog()
    {
        $blog = Blog::factory()->create();
        $this->json('GET', 'api/blogs/' . $blog->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => $blog->id,
                    "title" => $blog->title,
                    "description" => $blog->description,
                    "image" => url('/storage/blog/' . $blog->image)
                ]
            ]);
    }

    /** @test */
    public function it_can_update_a_blog()
    {
        $faker = Factory::create();
        $blog = Blog::factory()->create();

        $data = [
            'title' => $faker->sentence(),
            'description' => $faker->paragraph(),
            'image' => UploadedFile::fake()->image('image' . time() . '.png', 640, 480),
        ];

        $this->json('PUT', 'api/blogs/' . $blog->id, $data, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "message" => "Blog Updated Successfully",
            ]);
    }

    /** @test */
    public function it_can_delete_a_blog()
    {
        $blog = Blog::factory()->create();

        $this->json('DELETE', 'api/blogs/' . $blog->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "message" => "Blog Deleted Successfully",
            ]);
    }

    public function it_can_list_blogs()
    {
        $blog = Blog::factory()->create();
        $this->json('GET', 'api/blogs/', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function testRequiredFieldsToCreateBlog()
    {
        $this->json('POST', 'api/blogs', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The title field is required. (and 2 more errors)",
                "errors" => [
                    "title" => ["The title field is required."],
                    "description" => ["The description field is required."],
                    "image" => ["The image field is required."],
                ]
            ]);
    }
}
