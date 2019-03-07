<?php

namespace DgoraWcas\Admin;

use  DgoraWcas\Engines\TNTSearch\Indexer\Readable\Database as ReadableIndex ;
use  DgoraWcas\Engines\TNTSearch\Indexer\Taxonomy\Database as TaxonomyIndex ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Install
{
    /**
     * Hook in tabs.
     */
    public static function maybe_install()
    {
        add_action( 'admin_init', array( __CLASS__, 'check_version' ), 5 );
    }
    
    /**
     * Install
     */
    public static function install()
    {
        if ( !defined( 'DGWT_WCAS_INSTALLING' ) ) {
            define( 'DGWT_WCAS_INSTALLING', true );
        }
        self::save_activation_date();
        self::create_options();
        self::backwardCompatibility();
        // Update plugin version
        update_option( 'dgwt_wcas_version', DGWT_WCAS_VERSION );
    }
    
    /**
     * Default options
     */
    private static function create_options()
    {
        global  $dgwt_wcas_settings ;
        $sections = DGWT_WCAS()->settings->settings_fields();
        $settings = array();
        if ( is_array( $sections ) && !empty($sections) ) {
            foreach ( $sections as $options ) {
                if ( is_array( $options ) && !empty($options) ) {
                    foreach ( $options as $option ) {
                        if ( isset( $option['name'] ) && !isset( $dgwt_wcas_settings[$option['name']] ) ) {
                            $settings[$option['name']] = ( isset( $option['default'] ) ? $option['default'] : '' );
                        }
                    }
                }
            }
        }
        $update_options = array_merge( $settings, $dgwt_wcas_settings );
        update_option( DGWT_WCAS_SETTINGS_KEY, $update_options );
    }
    
    /**
     * Save activation timestamp
     * Used to display notice, asking for a feedback
     *
     * @return null
     */
    private static function save_activation_date()
    {
        $date = get_option( 'dgwt_wcas_activation_date' );
        if ( empty($date) ) {
            update_option( 'dgwt_wcas_activation_date', time() );
        }
    }
    
    /**
     * Set options for backward compatibility
     *
     * @return void
     */
    private static function backwardCompatibility()
    {
        $lastVersion = get_option( 'dgwt_wcas_version' );
        // New install? stop it
        if ( empty($lastVersion) ) {
            return;
        }
        $bcVersion = get_option( 'dgwt_wcas_backward_compatibility_version' );
        $backwardCompatibility = get_option( 'dgwt_wcas_backward_compatibility' );
        if ( DGWT_WCAS_VERSION === $bcVersion ) {
            return;
        }
        // If backward compatibility version is not set, last plugin version should be last stable version.
        
        if ( empty($bcVersion) ) {
            $lastStableVersion = $lastVersion;
        } else {
            $lastStableVersion = $bcVersion;
        }
        
        // Current version is larger that 1.1.7? Update options
        
        if ( version_compare( $lastStableVersion, '1.1.7', '<=' ) ) {
            if ( empty($bcVersion) ) {
                update_option( 'dgwt_wcas_backward_compatibility_version', '1.1.7' );
            }
            if ( empty($backwardCompatibility) ) {
                update_option( 'dgwt_wcas_backward_compatibility', 'on' );
            }
        }
        
        // For the next backward compatibility
        //        if(
        //            version_compare($lastStableVersion, 'x.x.x', '<=')
        //            && version_compare($lastStableVersion, 'x.x.x', '>')
        //            ) {
        //        }
    }
    
    /**
     * Check version
     */
    public static function check_version()
    {
        if ( !defined( 'IFRAME_REQUEST' ) ) {
            if ( get_option( 'dgwt_wcas_version' ) != DGWT_WCAS_VERSION ) {
                self::install();
            }
        }
    }

}