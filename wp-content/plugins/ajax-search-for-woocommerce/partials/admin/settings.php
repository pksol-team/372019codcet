<?php
// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

?>
<div class="wrap dgwt-wcas-settings<?php echo dgoraAsfwFs()->is_premium() ? ' dgwt-wcas-settings-pro' : ''; ?>">

    <h2><?php
        if (dgoraAsfwFs()->is_premium()) {
            _e('AJAX Search for WooCommerce (PRO) Settings', 'ajax-search-for-woocommerce');
        } else {
            _e('AJAX Search for WooCommerce Settings', 'ajax-search-for-woocommerce');
        }
        ?>
    </h2>

    <?php echo DGWT_WCAS()->backwardCompatibility->notice(); ?>


    <?php $settings->show_navigation(); ?>
    <?php $settings->show_forms(); ?>

</div>