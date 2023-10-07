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

        $this->assertTrue(Cache::has('test_key'));
    }

    public function testDeleteKey()
    {
        $key = 'test_key';
        $value = 'test_value';
        Cache::put($key, $value);

        $response = $this->delete('/api/key-value/delete?key=' . $key);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Key deleted from the store']);

        $this->assertNull(Cache::get($key));
    }
}
