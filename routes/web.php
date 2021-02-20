<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','QuestionController@index')->name('questions.index');

Route::resource('questions','QuestionController')->except('show');
Route::get('questions/{slug}/show','QuestionController@show')->name('questions.show');

Route::resource('questions.answers','AnswerController')->except('show','create');
Route::post('/answers/accept/{answer}','AnswerAcceptController')->name('answers.accepted');

Route::post('/questions/{question}/favourite','FavoriteController@store')->name('favourites.store');
Route::delete('/questions/{question}/favourite','FavoriteController@destroy')->name('favourites.destroy');

Route::post('/answers/{answer}/vote','AnswerVoteController')->name('answers.vote');
Route::post('/questions/{question}/vote','QuestionVoteController')->name('questions.vote');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
