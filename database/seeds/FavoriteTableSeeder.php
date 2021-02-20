<?php

use Illuminate\Database\Seeder;

class FavoriteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favourites')->delete();

        $user = \App\User::all()->pluck('id');
        $numberOfUsers = $user->count();
        $questions = \App\Question::all();

        foreach ($questions  as $question){
            for ($i = 0; $i<rand(1,$numberOfUsers); $i++){
                $userId = $user[$i];
                $question->favourites()->attach($userId);
            }
        }
    }
}
