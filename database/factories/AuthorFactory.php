<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function newProfile(){
      return $this->afterCreating(function($author){

          $author->profile()->save(Profile::factory()->make());
      });
    }

    public function afterProfileExists(){
        
        return $this->afterMaking(function($author){
            $author->profile()->save(Profile::factory()->make());
        });
    }
    
}
