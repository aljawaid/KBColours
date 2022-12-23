<?php

namespace Kanboard\Plugin\KBColours;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        // CSS - Asset Hook
        //  - Keep filename lowercase
        $this->hook->on('template:layout:css', array('template' => 'plugins/KBColours/Assets/css/kb-colours.css'));

        // Views - Add Menu Item - Template Hook
        //  - Override name should start lowercase e.g. pluginNameExampleCamelCase
        $this->template->hook->attach('template:config:sidebar', 'kBColours:config/sidebar');

        // Extra Page - Routes
        //  - Example: $this->route->addRoute('/my/custom/route', 'myController', 'show', 'PluginNameExampleStudlyCaps');
        //  - Must have the corresponding action in the matching controller
        $this->route->addRoute('/settings/colours', 'KBColoursController', 'show', 'KBColours');

        $this->hook->on('model:color:get-list', function (&$listing) {
            $new_colors = array(
                'maroon' => array(
                    'name' => 'Maroon',
                    'background' => '#e6ee9c',
                    'border' => '#afb42b',
                    'text-color' => '#e6ee9c',
                ),
                'white' => array(
                    'name' => 'White',
                ),
            );
            $new_list = array();
            foreach ($new_colors as $color_id => $color) {
                $new_list[$color_id] = t($color['name']);
            }
            $listing = array_merge($listing, $new_list);
            return $listing;

        });
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        // Plugin Name MUST be identical to namespace for Plugin Directory to detect updated versions
        // Do not translate the plugin name here
        return 'KBColours';
    }

    public function getPluginDescription()
    {
        return t('This plugin shows the actual colour values (background and matching border) for all the default Kanboard colours in the application settings.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '1.1.0';
    }

    public function getCompatibleVersion()
    {
        // Examples:
        // >=1.0.37
        // <1.0.37
        // <=1.0.37
        return '>=1.2.20';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/KBColours';
    }
}
