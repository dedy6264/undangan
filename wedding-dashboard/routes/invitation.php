<?php
Route::get('invitation/{id}', [InvitationController::class, 'index'])->name('user.index');