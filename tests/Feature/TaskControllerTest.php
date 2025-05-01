<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_tasks()
    {
        //create admin and users
        $admin = User::factory()->create(['role' => 'Admin']);
        $user = User::factory()->create();

        //create task for task list
        $task = Task::factory()->create(['user_id' => $user->id, 'created_by' => $admin->id]);

        //login user
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //get list of task based on user
        $response = $this->actingAs($user)->get('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        //create a user
        $user = User::factory()->create();

        //login user
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //create a post
        $data = [
            'title' => 'Test Task',
            'description' => 'Test task description',
            'priority' => 'Medium',
            'status' => 'todo',
            'user_id' => $user->id,
            'due_date' => '2024-12-31',
        ];

        $response = $this->actingAs($user)->post('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Task']);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        //create a user
        $user = User::factory()->create();

        //create task with assigned to
        $task = Task::factory()->create(['user_id' => $user->id]);

        //login user
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //update task details for specific task
        $data = [
            'title' => 'Updated Task Title',
            'description' => 'Updated task description',
            'priority' => 'High',
            'status' => 'in_progress',
            'user_id' => $user->id,
            'due_date' => '2024-11-30',
        ];

        $response = $this->actingAs($user)->put("/api/tasks/{$task->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Task Title']);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        //create a user
        $user = User::factory()->create();

        //create a task with details
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'created_by' => $user->id,
        ]);

        //login user
        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        //delete task
        $response = $this->actingAs($user)->delete("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => 'Task Deleted Successfully']);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}