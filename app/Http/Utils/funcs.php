<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// function getGuardNameByCurrentRoute()
function getGuardNameByCurrentRoute(): string|bool
{
    $route = Route::current();
    // check if route start with 'dashboard/admin'
    if (strpos($route->uri(), 'dashboard/admin') === 0) {
        return 'admin';
    } else if (strpos($route->uri(), 'dashboard/teacher') === 0) {
        return 'teacher';
    } else {
        return false;
    }
}

function getAuthGuardByCurrentRoute(): \Illuminate\Contracts\Auth\Guard
{
    $guardName = getGuardNameByCurrentRoute();
    return Auth::guard($guardName);
}

// function getDashboardGuardByCurrentRoute()
function getDashboardGuardByCurrentRoute()
{
    $guardName = getGuardNameByCurrentRoute();
    if ($guardName === 'admin') {
        return route('dashboard.admin.home');
    } else if ($guardName === 'teacher') {
        return route('dashboard.teacher.home');
    } else {
        return route('login');
    }
}
