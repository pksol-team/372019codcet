<?php

namespace DgoraWcas\Integrations\Themes;

class ThemesCompatibility
{
    private $themeName = '';

    public function __construct()
    {
        $this->setCurrentTheme();

        $this->loadCompatibilities();
    }

    private function setCurrentTheme()
    {
        $name = '';

        $theme = wp_get_theme();

        if (is_object($theme) && is_a($theme, 'WP_Theme')) {
            $name = strtolower($theme->Name);

            $template = $theme->Template;
            if ( ! empty($template)) {
                $name = $template;
            }
        }

        $this->themeName = $name;
    }

    private function loadCompatibilities()
    {

        switch ($this->themeName) {
            case 'storefront':
                new Storefront;
                break;
        }

    }

}