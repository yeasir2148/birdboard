<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_create_a_project() {
        $this->withoutExceptionHandling();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes, 'sqlite_testing');
        

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_create_request_has_a_title()
    {
        $attr = factory('App\Project')->raw(['title'=>null]);
        $this->post('/projects', $attr)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_create_request_has_a_description()
    {
        $attr = factory('App\Project')->raw(['description'=>null]);
        $this->post('/projects', $attr)->assertSessionHasErrors(['description']);
    }
    
    /** @test */
    public function a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        // Given a project
        $project = factory('App\Project')->create();

        // when user visits a page, he should see the project
        $this->get($project->path())->assertSee($project->title);
    }
    
}
