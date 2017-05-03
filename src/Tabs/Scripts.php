<?php

namespace HWP\Theme\Tabs;

use Carbon_Fields\Field;
use ReflectionFunction;

class Scripts
{

    /**
     * @var string
     */
    public $hook = 'after_theme_setup';

    /**
     * @var int
     */
    public $priority = 9999;

    /**
     * @var string
     */
    protected $prefix = 'hwp_theme_scripts';

    /**
     * @param array $tabs
     * @return array
     */
    public function register($tabs = [])
    {
        $tabs[__('WP Scripts')] = $this->getSettings();

        return $tabs;
    }

    public function run()
    {

    }

    /**
     * Get settings
     *
     * @return array
     */
    private function getSettings()
    {

        return [Field::make('text', 'crb_subtitle')];
    }

}