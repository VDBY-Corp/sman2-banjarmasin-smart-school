<?php

namespace App\Http\Controllers\Dashboard\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Facades\Setting as SettingFacade;

class SettingController extends Controller
{
    public function school()
    {
        return view('pages.dashboard.admin.master-data.setting.index', ['category' => 'school']);
    }

    public function ui()
    {
        return view('pages.dashboard.admin.master-data.setting.index', ['category' => 'ui']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $category = $request->category;
        $settings = SettingFacade::getAll("{$category}.");

        // validate each setting
        foreach ($settings as $key => $value) {
            $key = str_replace("{$category}.", "{$category}_", $key);
            $request->validate([
                $key => 'required',
            ]);
        }

        // update each setting
        foreach ($settings as $key => $value) {
            $request_key = str_replace("{$category}.", "{$category}_", $key);
            $val = $request->$request_key;
            if (SettingFacade::getType($key) == 'integer') {
                $val = intval($val);
            } else if (SettingFacade::getType($key) == 'boolean') {
                $val = boolval($val);
            } else if (SettingFacade::getType($key) == 'string') {
                $val = strval($val);
            } else {
                $val = strval($val);
            }
            SettingFacade::set($key, $val);
        }

        // setting point
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil menyimpan pengaturan',
        ]);
    }
}
