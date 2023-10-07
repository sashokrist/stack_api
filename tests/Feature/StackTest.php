<?php

namespace Tests\Feature;

use App\Models\StackItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class StackTest extends TestCase
{
    use RefreshDatabase;

    public function testAddItemToStack()
    {
        $response = $this->post('/api/stack/add', ['content' => 'Test Item']);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Item added to the stack']);

        // Check if the item was actually added to the stack (you may need to adjust this based on your implementation)
        $this->assertEquals(1, StackItem::count());
    }

    public function testAddKey()
    {
        $response = $this->post('/api/key-value/add', [
            'key' => 'test_key',
            'value' => 'test_value',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Key added to the store']);

        // Check if the key-value pair was actually added to the store (you may need to adjust this based on your implementation)
        $this->assertTrue(Cache::has('test_key'));
    }

    public function testDeleteKey()
    {
        // Arrange: Add a key-value pair to the store
        $key = 'test_key';
        $value = 'test_value';
        Cache::put($key, $value);

        // Act: Send a DELETE request to delete the key
        $response = $this->delete('/api/key-value/delete?key=' . $key);

        // Assert 1: Check the response status code (assuming a successful deletion)
        $response->assertStatus(200)
            ->assertJson(['message' => 'Key deleted from the store']);

        // Assert 2: Verify that the key has been deleted from the store
        $this->assertNull(Cache::get($key));
    }
}
