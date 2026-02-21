Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
