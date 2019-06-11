<?php

namespace Nambit\SlickSliderStaticPages\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'nambit_slicksliderstaticpages_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
    
    public function getDropdownOptions()
    {
        $theme = \Cms\Classes\Theme::getEditTheme();
        $pageRecords = \RainLab\Pages\Classes\Page::listInTheme($theme, true);
        $pages = [];
        foreach ($pageRecords as $name => $pageObject) {
            $url = $pageObject->getViewBag()->url;
            $pages[$url] = $pageObject->title . ' (' . $url . ')';
        }
        return $pages;
    }
}

