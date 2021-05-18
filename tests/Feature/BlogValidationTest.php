<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogValidationTest extends TestCase
{
    use RefreshDatabase;


    public function setup(): void
    {
        parent::setup();
        $this->withExceptionHandling();
        $this->createAuthUser();
        $this->get('/blog/create');
    }
    /** @test
     */
    public function createValidation()
    {
        //prepare
       
        //act
     
        $res =$this->post(route('blog.store'))->assertRedirect(route('blog.create'));

        //assertion
        $res->assertSessionHasErrors(['title', 'body', 'image']);

    }
      /** @test
     */
    public function createValidationImage()
    {
        //prepare
       
        //act
       
        $res =$this->post(route('blog.store'), ['image' => 'test image']
        )->assertRedirect(route('blog.create'));

        //assertion
        $res->assertSessionHasErrors('image');

    }


}
