<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use Inertia\Inertia;
Route::get('/',fn()=>redirect('/leads'));
Route::get('/automation',fn()=>Inertia::render('Automation/Index'))->name('automation.index');
Route::get('/leads',[LeadController::class,'index'])->name('leads.index');
Route::post('/leads',[LeadController::class,'store'])->name('leads.store');
Route::delete('/leads/{lead}',[LeadController::class,'destroy'])->name('leads.destroy');
