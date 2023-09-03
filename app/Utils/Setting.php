<?php
namespace App\Utils;

use App\Models\Setting as ModelsSetting;

class Setting {
    // temps settings
    private $settings = [];

    public function load()
    {
        $settings = \App\Models\Setting::all();
        foreach ($settings as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }

    public function get($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function set($key, $value)
    {
        $this->settings[$key] = $value;
        ModelsSetting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function getAll() {
        return collect($this->settings);
    }
}
