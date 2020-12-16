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

Route::get('/', ['as' => 'frontend.index', 'uses' => 'Frontend\indexcontroller@index']);
// Authentication Routes...
Route::get('/login',                            ['as' => 'frontend.show_login_form',        'uses' => 'Frontend\Auth\LoginController@showLoginForm']);
Route::post('login',                            ['as' => 'frontend.login',                  'uses' => 'Frontend\Auth\LoginController@login']);
Route::post('logout',                           ['as' => 'frontend.logout',                 'uses' => 'Frontend\Auth\LoginController@logout']);
Route::get('register',                          ['as' => 'frontend.show_register_form',     'uses' => 'Frontend\Auth\RegisterController@showRegistrationForm']);
Route::post('register',                         ['as' => 'frontend.register',               'uses' => 'Frontend\Auth\RegisterController@register']);
Route::get('password/reset',                    ['as' => 'password.request',                'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email',                   ['as' => 'password.email',                  'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}',            ['as' => 'password.reset',                  'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset',                   ['as' => 'password.update',                 'uses' => 'Frontend\Auth\ResetPasswordController@reset']);
Route::get('email/verify',                      ['as' => 'verification.notice',             'uses' => 'Frontend\Auth\VerificationController@show']);
Route::get('/email/verify/{id}/{hash}',         ['as' => 'verification.verify',             'uses' => 'Frontend\Auth\VerificationController@verify']);
Route::post('email/resend',                     ['as' => 'verification.resend',             'uses' => 'Frontend\Auth\VerificationController@resend']);

Route::group(['middleware' => 'verified'], function () {
Route::get('/dashboard',                        ['as' => 'frontend.dashboard',              'uses' => 'Frontend\userscontroller@index']);
Route::get('/create-post',                      ['as' => 'users.post.create',               'uses' =>  'Frontend\userscontroller@create']);
Route::post('/store-post',                      ['as' => 'users.post.store',                'uses' =>  'Frontend\userscontroller@store']);

});

/// Back End Routes //
Route::group(['prefix' => 'admin'],function(){

Route::get('/login',                            ['as' => 'admin.show_login_form',                 'uses' => 'Backend\Auth\LoginController@showLoginForm']);
Route::post('login',                            ['as' => 'admin.login',                           'uses' => 'Backend\Auth\LoginController@login']);
Route::post('logout',                           ['as' => 'admin.logout',                          'uses' => 'Backend\Auth\LoginController@logout']);
Route::get('password/reset',                    ['as' => 'admin.password.request',                'uses' => 'Backend\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email',                   ['as' => 'admin.password.email',                  'uses' => 'Backend\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}',            ['as' => 'admin.password.reset',                  'uses' => 'Backend\Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset',                   ['as' => 'admin.password.update',                 'uses' => 'Backend\Auth\ResetPasswordController@reset']);
Route::get('email/verify',                      ['as' => 'admin.verification.notice',             'uses' => 'Backend\Auth\VerificationController@show']);
Route::get('/email/verify/{id}/{hash}',         ['as' => 'admin.verification.verify',             'uses' => 'Backend\Auth\VerificationController@verify']);
Route::post('email/resend',                     ['as' => 'admin.verification.resend',             'uses' => 'Backend\Auth\VerificationController@resend']);
});

///###########################################################################
Route::get('/search',                           ['as' => 'frontend.search',            'uses' => 'Frontend\indexcontroller@search']);
Route::get('/contact_us',                       ['as' => 'show_contactus',             'uses' => 'Frontend\indexcontroller@contact_us']);
Route::post('/contact_us_store',                ['as' => 'store_contactus',            'uses'=> 'Frontend\indexcontroller@do_contactus']);
Route::get('/archive/{date}',                  ['as' => 'fronyend.archive.post',      'uses'=> 'Frontend\indexcontroller@archive']);
Route::get('/category/{category_slug}',         ['as'=> 'frontend.category.posts',     'uses'=> 'Frontend\indexcontroller@category']);
Route::get('/author/{username}',                ['as'=> 'frontend.author.posts',       'uses'=> 'Frontend\indexcontroller@author']);
Route::get('/{post_slug}',                      ['as' => 'posts.show',                 'uses'=>'Frontend\indexcontroller@post_show']);
Route::post('/{post_comment}',                  ['as' => 'posts.add.comment',          'uses'=>'Frontend\indexcontroller@store_comment']);
