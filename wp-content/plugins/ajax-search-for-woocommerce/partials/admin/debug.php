<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wrap">

    <h2>Ajax Search for WooCommerce Debug</h2>


    <h3>Backward Compatibility</h3>
    <?php DGWT_WCAS()->backwardCompatibility->printDebug(); ?>

</div>