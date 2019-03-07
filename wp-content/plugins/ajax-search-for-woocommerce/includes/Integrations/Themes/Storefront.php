<?php

namespace DgoraWcas\Integrations\Themes;


class Storefront
{

    public function __construct()
    {
        $this->overwriteFunctions();

        add_filter('dgwt/wcas/settings/section=basic', array($this, 'registerSettings'));
    }

    private function overwriteFunctions()
    {
        if ($this->canReplaceSearch()) {
            require_once DGWT_WCAS_DIR . 'partials/storefront.php';
        }
    }

    public function registerSettings($settings)
    {

        $settings[] = array(
            'name'  => 'storefront_settings_head',
            'label' => __('Storefront theme', 'ajax-search-for-woocommerce'),
            'type'  => 'head',
            'class' => 'dgwt-wcas-sgs-header'
        );

        $settings[] = array(
            'name'    => 'storefront_replace_search',
            'label'   => __('Replace search form', 'ajax-search-for-woocommerce'),
            'desc'    => __('Replace the Storefront theme\'s default product search with the Ajax Search for WooCommerce form.', 'ajax-search-for-woocommerce'),
            'type'    => 'checkbox',
            'default' => 'off',
        );

        return $settings;
    }

    /**
     * Check if can replace the native Storefront search form
     * by the Ajax Search for WooCommerce form.
     *
     * @return bool
     */
    private function canReplaceSearch()
    {
        $canIntegrate = false;

        if (DGWT_WCAS()->settings->get_opt('storefront_replace_search', 'off') === 'on') {
            $canIntegrate = true;
        }

        return $canIntegrate;
    }

}