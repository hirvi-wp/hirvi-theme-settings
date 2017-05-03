<?php

namespace HWP\Theme;

use Carbon_Fields\Container;

class Settings
{

    /**
     * @var string
     */
    protected $prefix = 'hwp_theme';

    /**
     * Initialize theme options
     */
    public function setup()
    {
        $container = Container::make('theme_options', 'HWP - Theme Settings')
            ->set_page_parent('themes.php')
            ->set_icon('dashicons-admin-settings');

        $tabs = apply_filters('hwp_theme_tabs', []);

        foreach($tabs as $tab => $options) {
            $container->add_tab($tab, $options);
        }
    }

    /**
     * Handle saved data
     */
    public function handleData()
    {
        return true;
    }

}