<?php namespace Nambit\SlickSliderStaticPages\components;

use peterhegman\slickslider\models\SlideShows;
use Symfony\Component\HttpFoundation\Request;
use Log;

class PageSlider extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Slider',
            'description' => 'Displays a slider selected by the user (via Static Pages)'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        // @todo check if page ist a static page and load default otherwise
        if (isset($this->page->page->apiBag['staticPage'])) {
            $slideShowId = $this->getSlideShowId();
            $slideShows = SlideShows::where('id', '=', $slideShowId)->first();
            if ($slideShows !== null && $slideShows->attributes['include_jquery']) {
                $this->addJs('/plugins/peterhegman/slickslider/assets/jquery-3.1.1.min.js');
            }
            $this->addJs('/plugins/peterhegman/slickslider/assets/slick/slick.min.js');
            $this->addCss('/plugins/peterhegman/slickslider/assets/slick/slick.css');
            $this->addCss('/plugins/peterhegman/slickslider/assets/slick/slick-theme.css');
       }
    }

    // This array becomes available on the page as {{ component.slides }}
    public function slides()
    {
    
        //@todo get Page variables and inject slider 
        $slideShowId = $this->getSlideShowId();
        //dd($slideShowId, $this->page->page->apiBag['staticPage']);
        $slideShows = SlideShows::where('id', '=', $slideShowId)->first();
        if ($slideShows !== null) {
            $breakpoints = json_decode($slideShows->attributes['responsive']);
            //Create Responsive Array
            $breakpointArray = array();
            $i = 0;
            foreach ($breakpoints as $breakpoint) {
                $breakpointArray[$i]['breakpoint'] = (int)$breakpoint->breakpoint;
                $breakpointArray[$i]['settings']['slidesToShow'] = ( $breakpoint->responsive_slides_to_show ? (int)$breakpoint->responsive_slides_to_show : 1 );
                $breakpointArray[$i]['settings']['slidesToScroll'] = ( $breakpoint->responsive_slides_to_scroll ? (int)$breakpoint->responsive_slides_to_scroll : 1 );
                $breakpointArray[$i]['settings']['rows'] = ( $breakpoint->responsive_rows ? (int)$breakpoint->responsive_rows : 1 );
                $breakpointArray[$i]['settings']['slidesPerRow'] = ( $breakpoint->responsive_slides_per_row ? (int)$breakpoint->responsive_slides_per_row : 1 );
                $i++;
            }
            $breakpointJson = json_encode($breakpointArray);
            return compact('slideShows', 'breakpointJson');
        } else {
            $slideShows = 'no_slider';
            return compact('slideShows');
        }
    }
    
    protected function getSlideShowId()
    {
        // @todo check if isset otherwise load fallback
        return $this->page->page->apiBag['staticPage']->viewBag['slide_show'];
    }
}
