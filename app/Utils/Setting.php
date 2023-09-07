<?php
namespace App\Utils;

use App\Models\Setting as ModelsSetting;

class Setting {
    // temps settings
    private $settings = [];
    private $settings_types = [];

    public function load()
    {
        $settings = \App\Models\Setting::all();
        foreach ($settings as $setting) {
            $val = $setting->value;
            if ($setting->type == 'integer') {
                $val = intval($val);
            } else if ($setting->type == 'boolean') {
                $val = boolval($val);
            } else if ($setting->type == 'string') {
                $val = strval($val);
            }
            $this->settings[$setting->key] = $val;
            $this->settings_types[$setting->key] = $setting->type;
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

    public function getAll(String $prefix = null) {
        $settings = collect($this->settings);
        if ($prefix) {
            $settings = $settings->filter(function ($value, $key) use ($prefix) {
                return strpos($key, $prefix) === 0;
            });
        }
        return $settings;
    }

    public function getTypes(String $key) {
        return $this->settings_types[$key] ?? 'string';
    }
}
