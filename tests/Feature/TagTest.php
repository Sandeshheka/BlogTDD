<?php

namespace Tests\Feature;

use App\Tag;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;



    /** @test
     */
    public function userCreateTag()
    {

        //prepare

        //act
        $res =$this->post(route('tag.store'), ['name' => 'Laravel']);

        //assertion
        $res->assertRedirect(route('tag.index'));
        $this->assertDatabaseHas('tags', ['name' => 'Laravel']);
    }

       /** @test
     */
    public function userAllTags()
    {

        //prepare
        $tag = $this->createTag();
        //act
        $res =$this->get(route('tag.index'));

        //assertion
        $res->assertStatus(200);
       $res->assertSee($tag->name);
    }

         /** @test
     */
    public function userDeleteTags()
    {

        //prepare
        $tag =$this->createTag();
      
        //act
        $res =$this->delete(route('tag.destroy', $tag->slug));

        //assertion
        $res->assertRedirect(route('tag.index'));
       $this->assertDatabaseMissing('tags', ['name' => $tag->name]);
    }

            /** @test
     */
    public function userDeleteBlogTags()
    {

        //prepare
        $tag =$this->createTag();
        $blog = $this->createBlog();
        $tag->blogs()->attach($blog->id);
        //act
        $res =$this->delete(route('tag.destroy', $tag->slug));

        //assertion

       $this->assertDatabaseMissing('blog_tag', [
           'blog_id' => $blog->id,
            'tag_id' => $tag->id
           ]);
           $this->assertDatabaseHas('blogs', ['id'=> $blog->id]);
    }
    
         /** @test
     */
    public function userUpdateTags()
    {

        //prepare
        $tag =$this->createTag();
        //act
        $res =$this->patch(route('tag.update', $tag->slug), ['name' => 'Sandesh']);

        //assertion
        $res->assertRedirect(route('tag.index'));
       $this->assertDatabaseHas('tags', ['name' => 'Sandesh']);
    }

            /** @test
     */
    public function userVisitTagCreate()
    {

        //prepare
     
        //act
        $res =$this->get(route('tag.create'));

        //assertion
        $res->assertOk();
        $res->assertSee('Create New Tag');
       
    }

                /** @test
     */
    public function userVisitTagEdit()
    {

        //prepare
        $tag = $this->createTag();
        //act
        $res =$this->get(route('tag.edit', $tag->slug));

        //assertion
        $res->assertOk();
        $res->assertSee('Update The Tag');
       
    }
}
