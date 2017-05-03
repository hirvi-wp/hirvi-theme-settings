<?php

namespace HWP\Theme\Tabs;

use Carbon_Fields\Field;
use ReflectionFunction;

class Head
{

    /**
     * @var string
     */
    public $hook = 'init';

    /**
     * @var int
     */
    public $priority = 9999;

    /**
     * @var string
     */
    protected $prefix = 'hwp_theme_head';

    /**
     * @param array $tabs
     * @return array
     */
    public function register($tabs = [])
    {
        $tabs[__('WP Head')] = $this->getSettings();

        return $tabs;
    }

    /**
     * An action hooked into the 'init' hook.
     */
    public function run()
    {
        $options = carbon_get_theme_option('hwp_theme_head');

        if (  ! $options) {
            return;
        }

        $filters = $this->getHeadFilters();
        $filter_keys = array_keys($this->getHeadFilters());
        $diff = array_diff($filter_keys, $options);

        foreach($diff as $action) {
            remove_action('wp_head', $action, $filters[$action]['priority'], $filters[$action]['accepted_args']);
        }
    }

    /**
     * Get settings
     *
     * @return array
     */
    private function getSettings()
    {
        $return = [
            Field::make("html", $this->prefix . '_intro')
                ->set_html('<h1>WP Head settings</h1><p>Wordpress adds a lot of stuff inside the head-tag of your theme, here you can switch these ON/OFF. <br /><b><i>NOTE: You should know what you\'re doing before disabling some of these settings.</i></b></p>')
                ->set_width(50)
        ];

        $set = Field::make("set", $this->prefix, "Uncheck to disable");

        $options = [];
        foreach ($this->getHeadFilters() as $filter) {
            $rc = new ReflectionFunction($filter['function']);
            $options[$filter['function']] = '<b><i>' . $filter['function'] . '</i></b> - ' . $this->getFunctionDescription($rc->getDocComment()) . '';
        }

        $return[] = $set->set_options($options)->set_default_value(array_keys($options))->set_width(50);

        return $return;
    }

    /**
     * @return array
     */
    private function getHeadFilters()
    {
        $filters = $GLOBALS['wp_filter']['wp_head']->callbacks;

        $fs = [];
        foreach ($filters as $i => $filter) {
            foreach ($filter as $key => $arr) {
                if (is_array($arr['function'])) {
                    continue;
                }

                $arr['priority'] = $i;
                $fs[$key] = $arr;
            }
        }

        return $fs;
    }

    /**
     * @param string $comment
     * @return string
     */
    private function getFunctionDescription($comment)
    {
        $parts = explode("\n", $comment);

        return trim($parts[1], " *");
    }

}