<?php

use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\Demo\MiddlerwareController;
use App\Http\Controllers\Demo\SingleActionController;
use App\Http\Controllers\Demo\ColumnController;
use App\Http\Controllers\Demo\PhotoController;
use App\Http\Controllers\Demo\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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
    echo 'route(\'profile\') = ' . route('laravel9-health') . '<br>';
    return true;
})->name('laravel9-health');
// 命名路由后，可通过 $url = route('profile'); 获取路由的url 用于重定向 或 条件判定

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


//  路由组使用中间件
Route::middleware(['before.base', 'after.base'])->group(function () {
    Route::get('/middleware/index', [MiddlerwareController::class, 'index'])->middleware('before.special_auth');

    Route::get('/middleware/detail', [MiddlerwareController::class, 'detail'])->middleware('after.special_handle');

    # 单action控制器路由
    Route::get('/single-action', SingleActionController::class);
});

//  生成资源类代码  --api 比 --resource 少 create() 和 edit() 两个方法
//  php artisan make:controller Demo/PhotoController --resource --model=Photo --requests
//  php artisan make:controller PhotoController --api
Route::resource('photos', PhotoController::class)->missing(function (Request $request) {
    return Redirect::route('photos.index');
})->names([
    //  命名资源路由
    'create' => 'photos.build'
]);
//  命名资源路由参数  /users/{admin_user}
/**
 * ->parameters([
 *    'users' => 'admin_user'
 * ]);
 */

//  未定义的资源路由将重定向到404
Route::resources([
    'columns' => ColumnController::class,
    'posts' => PostController::class,
]);
//  TODO 嵌套资源  /photos/{photo}/comments/{comment}
// Route::resource('photos.comments', PhotoCommentController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
