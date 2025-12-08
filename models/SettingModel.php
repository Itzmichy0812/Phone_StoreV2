<?php

class SettingModel {
    private $settingsFile;
    private $settings = null;
    
    public function __construct() {
        $this->settingsFile = __DIR__ . '/../config/site_settings.json';
        $this->loadSettings();
    }
    
    // Load settings from JSON file
    private function loadSettings() {
        if (!file_exists($this->settingsFile)) {
            throw new Exception("Settings file not found: " . $this->settingsFile);
        }
        
        $json = file_get_contents($this->settingsFile);
        $this->settings = json_decode($json, true);
        
        if ($this->settings === null) {
            throw new Exception("Invalid JSON in settings file");
        }
    }
    
    // Save settings to JSON file
    private function saveSettings() {
        $json = json_encode($this->settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        if (file_put_contents($this->settingsFile, $json) === false) {
            return false;
        }
        
        return true;
    }
    
    // Get a single setting by key (supports dot notation: "contact.phone")
    public function get($key, $default = null) {
        $keys = explode('.', $key);
        $value = $this->settings;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    // Get all settings, optionally filtered by group
    public function getAll($group = null) {
        if ($group) {
            return $this->settings[$group] ?? [];
        }
        
        return $this->settings;
    }
    
    // Get settings by group
    public function getByGroup($group) {
        return $this->settings[$group] ?? [];
    }
    
    // Set a single setting value (supports dot notation)
    public function set($key, $value) {
        $keys = explode('.', $key);
        $current = &$this->settings;
        
        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                $current[$k] = $value;
            } else {
                if (!isset($current[$k]) || !is_array($current[$k])) {
                    $current[$k] = [];
                }
                $current = &$current[$k];
            }
        }
        
        return $this->saveSettings();
    }
    
    // Update multiple settings at once
    public function updateMultiple($settings) {
        foreach ($settings as $key => $value) {
            // Find which group this setting belongs to
            foreach ($this->settings as $group => $groupSettings) {
                // Remove group prefix from key if present (e.g., "contact_phone" -> "phone")
                $cleanKey = str_replace($group . '_', '', $key);
                
                if (isset($groupSettings[$cleanKey])) {
                    $this->settings[$group][$cleanKey] = $value;
                    break;
                }
            }
        }
        
        return $this->saveSettings();
    }
    
    // Delete a setting
    public function delete($key) {
        $keys = explode('.', $key);
        $current = &$this->settings;
        
        foreach ($keys as $i => $k) {
            if ($i === count($keys) - 1) {
                unset($current[$k]);
            } else {
                if (!isset($current[$k])) {
                    return false;
                }
                $current = &$current[$k];
            }
        }
        
        return $this->saveSettings();
    }
}
