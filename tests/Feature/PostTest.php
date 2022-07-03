<?php

namespace Tests\Feature;
use App\models\Comment;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

  
    public function testBlogPostWhenNothingInDatabase()
    {
            $response = $this->get('/posts');
            $response->assertSeeText('No posts found!');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments(){

        // Arrange 
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts',[
            'title' => 'New title'
        ]);
    }

    public function testeSee1BlogPostWithComments(){

        //Arrange
        $post = $this->createDummyBlogPost();
        Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');

    }

    public function testStoreValid(){

        

        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];


        $this->actingAs($this->user())->post('/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'The blog Post was created!');
    }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())->post('/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', ['title' => 'New title']);

        $params = [
            'title' => 'Hi my name is Bruno Miguel',
            'content' => 'Content was changed now. Thanks in advance!'
        ];

        $this->actingAs($user)->put("/posts/{$post->id}",$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was updated!');
        $this->assertDatabaseMissing('blog_posts',['title' => 'New title']);
        $this->assertDatabaseHas('blog_posts',['title'=>'Hi my name is Bruno Miguel']);

    }

    public function testDelete(){
       
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts',['title' => 'New title']);

        $this->actingAs($user)->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was deleted!');
        //$this->assertDatabaseMissing('blog_posts',['title'=>'New title']);
        $this->assertSoftDeleted('blog_posts', ['title' => 'New title']);

    }
    
    private function createDummyBlogPost($userId = null): BlogPost
    {
        //$post = new BlogPost();
        //$post->title = 'New title';
        //$post->content = 'Content of the blog post';
        //$post->save();



        return BlogPost::factory()->newtitle()->create(
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        );
    }
}
