<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Models\QueueModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Auth::guest() ? view('home') : redirect()->route('find', ['date' => date('Y-m-d')]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::match(['get', 'post'], '/find', function (Request $request) {
        $date = $request->input('date');
        return $date ? redirect()->route('find', ['date' => $date]) : redirect('/');
    });
    
    Route::get('/find/{date}', [MainController::class, 'home_find'])->name('find');

    Route::get('/setting', function () {
        $user = Auth::user();
        $settings = SettingModel::where('user_id', $user->id)->get();
        $queues = QueueModel::orderBy('queue')->get();
        return view('setting', compact('queues', 'settings'));
    })->name('setting');
    
    Route::post('/setting/update', [MainController::class, 'setting_update'])->name('setting.update');

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('outagelist');
        })->name('admin');

        Route::get('/queue', [AdminController::class, 'queue_show'])->name('queue');
        Route::get('/queue/{id}/delete', [AdminController::class, 'queue_delete'])->name('queue.delete');
        Route::post('/queue/rename', [AdminController::class, 'queue_rename']);

        Route::get('/queue/{id}/rename', function ($id) {
            $data = QueueModel::find($id);
            return view("queuerename", compact('data'));
        })->name('queue.rename');

        Route::post('/queue/add', [AdminController::class, 'queue_add'])->name('queue.add');

        Route::get('/outagelist', function () {
            return redirect()->route('outagelist.find', ['date' => date('Y-m-d')]);
        })->name('outagelist');

        Route::post('/outagelist/find', function (Request $request) {
            $date = $request->input('date');
            return redirect()->route('outagelist.find', ['date' => $date]);
        });

        Route::get('/outagelist/{date}', [AdminController::class, 'outagelist_find'])->name('outagelist.find');

        Route::get('/outagelist/{date}/add', [AdminController::class, 'outagelist_add_show']);

        Route::post('/outagelist/add', [AdminController::class, 'outagelist_add'])->name('outagelist.add');

        Route::get('/outagelist/{id}/delete', [AdminController::class, 'outagelist_delete']);

        Route::get('/outagelist/{id}/update', [AdminController::class, 'outagelist_update_show']);

        Route::patch('/outagelist/update', [AdminController::class, 'outagelist_update']);

        Route::get('/users', function () {
            $data = User::orderBy('name')->get();
            $user_exist = User::where('is_admin', false)->exists();
            return view('userslist', compact('data', 'user_exist'));
        })->name('users.show');
    });
});

require __DIR__.'/auth.php';
