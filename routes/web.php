<?php
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::delete('/playlist/{playlist}/song/{song}', [PlaylistController::class, 'removeSong'])->name('playlist.removesong');
Route::post('/playlist/{playlist}/song', [PlaylistController::class, 'addSong'])->name('playlist.addsong');

Route::resource('playlist', PlaylistController::class);
Route::post('playlist/{playlist}/addsong',[PlaylistController::class, 'addSong'])->name('playlist.addsong');
Route::resource('song', SongController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
