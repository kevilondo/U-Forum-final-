<?php

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

Route::get('/', 'PagesController@index');

Route::get('/new_article', 'PagesController@write_article');

Route::post('/new_article', 'ArticlesController@publish_article');

Route::get('/read_article/{id}', 'ArticlesController@read_article');

Route::get('/forum', 'TopicController@list_posts');

Route::get('/forum/course', 'TopicController@course_topics');

Route::post('/forum', 'TopicController@post_topic');

Route::get('/comment/{id}', 'TopicController@show_topic');

Route::post('/comment/{id}', 'CommentController@post_comment');

Route::get('/bookstore', 'BookstoreController@list_books');

Route::get('/bookstore/course', 'BookstoreController@course_books');

Route::post('/bookstore', 'BookstoreController@post_book');

Route::get('/profile', 'PagesController@profile');

Route::post('/profile', 'UsersController@change_avatar');

Route::post('/password', 'UsersController@change_password');

Route::post('/delete_account', 'UsersController@delete_account');

Route::get('/notifications', 'NotifController@list_notifications');

Route::get('/comment/seen/{post_id}/{notif_id}', 'NotifController@read_notification');

Route::get('/inbox', 'InboxController@inbox_page');

Route::get('/chat/{id}', 'InboxController@chat');

Route::post('/chat/{id}', 'InboxController@send_message');

Route::post('/files/{id}', 'InboxController@send_files');

Route::post('/register/fetch', 'CourseController@fetch')->name('CourseController.fetch');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/delete_topic/{id}', 'TopicController@delete_topic');

Route::get('/delete_comment/{id}/{topic}', 'CommentController@delete_comment');

Route::get('/delete/{id}', 'BookstoreController@delete');

Route::get('/contact', 'PagesController@contact');

Route::get('/about', 'PagesController@about_us');

Route::get('/update', 'PagesController@update');

Route::post('/update', 'UsersController@update');

Route::get('/articles', 'AdminController@list_articles');

Route::get('/article_accepted/{id}', 'AdminController@publish_article');

Route::get('/article_rejected/{id}', 'AdminController@reject_article');

Route::get('/article_delete/{id}', 'AdminController@delete_article');

Route::get('/contact_users', 'Staff\PagesController@contact_users');

Route::post('/contact_users', 'Staff\StaffController@contact_users');

Route::get('/mavuti-staff', 'Auth\LoginController@showStaffLoginForm');

Route::post('/mavuti-staff', 'Auth\LoginController@staffLogin');

Route::get('/mavuti-staff/register', 'Auth\RegisterController@showRegisterStaffForm');

Route::post('/mavuti-staff/register', 'Auth\RegisterController@createStaff');

Route::get('/mavuti-home', 'Staff\PagesController@index');

Route::get('/delete_staff_message/{id}', 'Staff\StaffController@delete_message');

Route::get('/list_topics', 'Staff\PagesController@list_topics');

Route::get('/topic/{id}', 'Staff\PagesController@topic');

Route::get('/staff_message/{id}', 'Staff\StaffMessagesController@show');

Route::post('/staff_message/{id}', 'CommentController@staff_message_comment');

Route::get('/staff_messages', 'Staff\StaffMessagesController@showAll');

Route::get('/delete_staff_comment/{comment_id}/{message_id}', 'CommentController@delete_staff_comment');

Route::get('/videos', 'VideosController@show_videos');

Route::post('/videos', 'VideosController@upload_videos');