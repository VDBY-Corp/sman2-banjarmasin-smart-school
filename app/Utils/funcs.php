<?php

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


function uploadFile(\Illuminate\Http\UploadedFile $file)
{
    $filename = md5(uniqid(rand(), true));
    DB::transaction(function () use ($file, $filename, &$path, &$created) {
        $created = File::create([
            'hash' => $filename,
            'ext' => $file->getClientOriginalExtension(),
            'file_name' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
        ]);
        $path = $file->storeAs('files', $filename);
    });
    return (object) [
        'path' => $path,
        'hash' => $filename,
        'ext' => $file->getClientOriginalExtension(),
        'file_name' => $file->getClientOriginalName(),
        'mime' => $file->getMimeType(),
        'created' => $created,
        'file_id' => $created->id,
    ];
}

function geFileProofValidationRule() {
    return 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120'; // max 5MB
}
