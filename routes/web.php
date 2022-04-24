<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| 命中第一条符合规则的解析，就不向下执行
*/


Route::get('/', function () {
    return view('welcome');
});

// 心跳检测
Route::get('/health', function () {
    return true;
});

// 解析到 controller action
Route::get('/demo/index', [DemoController::class, 'index']);

// 必填参数; 如果id传入是index，则走第一条命中的解析
Route::get('/demo/{id}', function ($id) {
    return 'User '.$id;
});
// 多个参数
Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return $postId . ' : '.$commentId;
});

// 正则表达式约束
Route::get('/userTest/{name}', function ($name) {
    return 'user/name：' . $name;
})->where('name', '[A-Za-z]+');

Route::get('/userTest/{id}', function ($id) {
    return 'user/id' . $id;
})->where('id', '[0-9]+');

Route::get('/userTest/{id}/{name}', function ($id, $name) {
    return 'user/id/name:' . $id . '/' . $name;
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
