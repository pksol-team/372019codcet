<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'storefront_product_search' ) ) {
    function storefront_product_search() {
        if ( storefront_is_woocommerce_activated() ) { ?>
            <div class="site-search">
                <?php echo do_shortcode( '[wcas-search-form]' ); ?>
            </div>
            <?php
        }
    }
}
add_action( 'wp_footer', 'dgwt_wcas_storefront_inverse_orientation' );

function dgwt_wcas_storefront_inverse_orientation() {
    ?>
    <script>
        jQuery(window).on('load', function () {
            var $footerSearch = jQuery('.storefront-handheld-footer-bar .dgwt-wcas-search-input');
            if ($footerSearch.length > 0) {

                $footerSearch.each(function(){
                    jQuery(this).dgwtWcasAutocomplete('setOptions', {
                            orientation: 'top',
                            positionFixed: true
                        }

                    );
                });

            }
        });
    </script>
    <?php
}