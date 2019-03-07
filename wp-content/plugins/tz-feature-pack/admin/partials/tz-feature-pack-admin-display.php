<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Tz_Feature_Pack
 * @subpackage Tz_Feature_Pack/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
<form method="post" action="options.php"><?php

settings_fields( $this->plugin_name . '-options' );

do_settings_sections( $this->plugin_name );

submit_button( 'Save Settings' );

?></form>
