<?php return [
    'plugin' => [
        'name' => 'SlickSliderStaticPages',
        'description' => 'Extension for PeterHegman\\SlickSlider to add Slider-Selection to StaticPages',
    ],
    'form' => [
        'settings' => [
            'pages_with_slider' => [
                'label' => 'Pages with dynamic Slider',
                'description' => 'Select pages with should have a dropdown with slider options',
            ],
        ],
    ],
    'menu' => [
        'settings' => 'Slider Extension',
    ],
];