<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_HomePageWorkingCorrectly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Welcome to Laravel!');
        $response->assertSeeText('This is the content of the main page!');
        
    }

    public function test_ContactPageIsWorkingCorrectly()
    {

        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSeeText('Contact');
        $response->assertSeeText('Hello this is contact!');


    }
}
