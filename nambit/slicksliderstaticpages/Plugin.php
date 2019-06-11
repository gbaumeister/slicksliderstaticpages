<?php namespace Nambit\SlickSliderStaticPages;

use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Event;

class Plugin extends PluginBase
{
    public $require = [
        'PeterHegman.SlickSlider',
        'RainLab.Pages',
    ];

    public function boot()
    {
        $this->injectSliderFields();
    }

    public function registerComponents()
    {
        return [
            'Nambit\SlickSliderStaticPages\Components\PageSlider' => 'page_slider'
        ];
    }
    
    public function registerSettings()
    {
        return [
            'nambit_slicksliderstaticpages' => [
                'label'       => 'Slide Show Settings',
                'description' => 'Manage Pages to add Slideshows.',
                'category'    => 'Slide Shows',
                'icon'        => 'icon-cog',
                'class'       => 'Nambit\SlickSliderStaticPages\Models\Settings',
                'order'       => 505,
                'permissions' => ['peterhegman.slickslider.manage_slide_shows'],
                'keywords'    => 'slide show settings'
            ],

        ];
    }
    
    public function injectSliderFields()
    {
        Event::listen('backend.form.extendFields', function ($widget) {

            if (
                !$widget->model instanceof \RainLab\Pages\Classes\Page
            ) {
                return;
            }


            $slideshows = \PeterHegman\SlickSlider\Models\SlideShows::pluck('slide_show_title', 'id');

            $widget->addTabFields([
                'viewBag[slide_show]' => [
                    'tab' => 'Slider',
                    'label' => 'Slideshow to display',
                    'comment' => 'Select the slider to be dislayed',
                    'type' => 'dropdown',
                    'options' => $slideshows
                ]
            ]);
        });
    }
    
    
}
