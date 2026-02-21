Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('users', UserController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});