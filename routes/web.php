<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'active_notes' => Note::getActive()->where('user_id',Auth::id())->orderBy('priority','desc')->get(),
        'completed_notes' => Note::getCompleted()->where('user_id',Auth::id())->orderBy('priority','desc')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/add-new-note', [NoteController::class, 'create'])->name('note.create');
Route::post('/edit-note/{id}', [NoteController::class, 'edit'])->name('note.edit');
Route::post('/complete-note/{id}', [NoteController::class, 'complete'])->name('note.complete');
Route::post('/activate-note/{id}', [NoteController::class, 'activate'])->name('note.activate');

// Route::post('/add-new-note', function (Request $request) {
//     $newNote = new NoteController();
//     $newNote->create($request);
//     return view('dashboard', [
//         'notes' => Note::where('user_id',Auth::id())
//     ]);
// })->middleware(['auth', 'verified'])->name('note.create');;
