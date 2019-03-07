<?php

namespace DgoraWcas;

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

class Helpers
{

    /**
     * Logger instance
     *
     * @var WC_Logger
     */
    public static $log = false;

    /**
     * Return ajax loader URL
     *
     * @param array args
     *
     * @return string
     */

    public static function get_admin_ajax_url($args = array())
    {

        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $ajax_url = admin_url('admin-ajax.php', $protocol);

        return add_query_arg($args, $ajax_url);
    }

    /**
     * Cut string
     *
     * @param string $string
     * @param int $length
     *
     * @return string
     */

    public static function strCut($string, $length = 40)
    {

        $string = strip_tags($string);

        if (strlen($string) > $length) {
            $title = mb_substr($string, 0, $length, 'utf-8') . '...';
        } else {
            $title = $string;
        }

        return $title;
    }

    /**
     * Add css classes to search form
     *
     * @param array $args
     *
     * @return string
     */

    public static function search_css_classes($args = array())
    {

        $classes = array();

        if (DGWT_WCAS()->settings->get_opt('show_details_box') === 'on') {
            $classes[] = 'dgwt-wcas-is-detail-box';
        }

        if (DGWT_WCAS()->settings->get_opt('show_submit_button') !== 'on') {
            $classes[] = 'dgwt-wcas-no-submit';
        }

        if (isset($args['class']) && ! empty($args['class'])) {
            $classes[] = esc_html($args['class']);
        }

        return implode(' ', $classes);
    }

    /**
     * Print magnifier SVG ico
     */

    public static function print_magnifier_ico()
    {
        ?>
        <svg version="1.1" class="dgwt-wcas-ico-magnifier" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 51.539 51.361" enable-background="new 0 0 51.539 51.361" xml:space="preserve">
		<path d="M51.539,49.356L37.247,35.065c3.273-3.74,5.272-8.623,5.272-13.983c0-11.742-9.518-21.26-21.26-21.26
			  S0,9.339,0,21.082s9.518,21.26,21.26,21.26c5.361,0,10.244-1.999,13.983-5.272l14.292,14.292L51.539,49.356z M2.835,21.082
			  c0-10.176,8.249-18.425,18.425-18.425s18.425,8.249,18.425,18.425S31.436,39.507,21.26,39.507S2.835,31.258,2.835,21.082z"/>
	</svg>
        <?php

    }

    /**
     * Get product desc
     *
     * @param int $product product object or The post ID
     * @param int $length description length
     *
     * @return string
     */

    public static function get_product_desc($product, $length = 130)
    {

        if (is_numeric($product)) {
            $product = wc_get_product($product);
        }

        $output = '';

        if ( ! empty($product)) {

            if (self::compare_wc_version('3.0', '>=')) {
                $short_desc = $product->get_short_description();
            } else {
                $short_desc = $product->post->post_excerpt;
            }

            if ( ! empty($short_desc)) {
                $output = self::strCut(wp_strip_all_tags($short_desc), $length);
            } else {
                if (self::compare_wc_version('3.0', '>=')) {
                    $desc = $product->get_description();
                } else {
                    $short_desc = $product->post->post_content;
                }
                if ( ! empty($desc)) {
                    $output = self::strCut(wp_strip_all_tags($desc), $length);
                }
            }
        }

        $output = html_entity_decode($output);

        return $output;
    }

    /**
     * Return HTML for the setting section "How to use?"
     *
     * @return string HTML
     */

    public static function how_to_use_html()
    {

        $html = '';

        ob_start();

        include DGWT_WCAS_DIR . 'partials/admin/how-to-use.php';

        $html .= ob_get_clean();

        return $html;
    }

    /**
     * Minify JS
     *
     * @see https://gist.github.com/tovic/d7b310dea3b33e4732c0
     *
     * @param string
     *
     * @return string
     */

    public static function minify_js($input)
    {

        if (trim($input) === "") {
            return $input;
        }

        return preg_replace(
            array(
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_]\w*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([\w\)\]])\[([\'"])([a-z_]\w*)\2\]#i',
                // Replace `true` with `!0`
                '#(?<=return |[=:,\(\[])true\b#',
                // Replace `false` with `!1`
                '#(?<=return |[=:,\(\[])false\b#',
                // Clean up ...
                '#\s*(\/\*|\*\/)\s*#'
            ), array(
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3',
            '!0',
            '!1',
            '$1'
        ), $input);
    }

    /**
     * Minify CSS
     *
     * @see https://gist.github.com/tovic/d7b310dea3b33e4732c0
     *
     * @param string
     *
     * @return string
     */

    public static function minify_css($input)
    {

        if (trim($input) === "") {
            return $input;
        }
        // Force white-space(s) in `calc()`
        if (strpos($input, 'calc(') !== false) {
            $input = preg_replace_callback('#(?<=[\s:])calc\(\s*(.*?)\s*\)#', function ($matches) {
                return 'calc(' . preg_replace('#\s+#', "\x1A", $matches[1]) . ')';
            }, $input);
        }

        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by a white-space or `=`, `:`, `,`, `(`, `-`
                '#(?<=[\s=:,\(\-]|&\#32;)0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][-\w]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s=:,\(]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s',
                '#\x1A#'
            ), array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2',
            ' '
        ), $input);
    }

    /**
     * Compare WooCommerce function
     *
     * @param $version
     * @param $op
     *
     * @return bool
     */
    public static function compare_wc_version($version, $op)
    {
        if (function_exists('WC') && (version_compare(WC()->version, $version, $op))) {
            return true;
        }

        return false;
    }

    /**
     * Get rating HTML
     *
     * @param $product object WC_Product
     *
     * @return string
     */
    public static function get_rating_html($product)
    {
        $html = '';

        if (self::compare_wc_version('3.0', '>=')) {
            $html = wc_get_rating_html($product->get_average_rating());
        } else {
            $html = $product->get_rating_html();
        }

        return $html;
    }

    /**
     * Check if is settings page
     * @return bool
     */
    public static function isSettingsPage()
    {
        if (is_admin() && ! empty($_GET['page']) && $_GET['page'] === 'dgwt_wcas_settings') {
            return true;
        }

        return false;
    }

    /**
     * Check if is Freemius checkout page
     * @return bool
     */
    public static function isCheckoutPage()
    {
        if (is_admin() && ! empty($_GET['page']) && $_GET['page'] === 'dgwt_wcas_settings-pricing') {
            return true;
        }

        return false;
    }

    /**
     * Get settings URL
     *
     * @return string
     */
    public static function getSettingsUrl()
    {
        return admin_url('admin.php?page=dgwt_wcas_settings');
    }

    /**
     * Get total products
     *
     * @return int
     */
    public static function getTotalProducts()
    {
        global $wpdb;

        $sql   = "SELECT COUNT(ID) FROM $wpdb->posts WHERE  post_type = 'product' AND post_status = 'publish'";
        $total = $wpdb->get_var($sql);

        return absint($total);

    }

    /**
     * Get all products IDs
     * @return array
     */
    public static function getProductsForIndex()
    {
        global $wpdb;


        $sql = "SELECT ID FROM $wpdb->posts WHERE post_type = 'product' AND post_status = 'publish' ORDER BY ID ASC";

        $ids = $wpdb->get_col($sql);

        if ( ! is_array($ids) || empty($ids[0]) || ! is_numeric($ids[0])) {
            $ids = array();
        }

        return $ids;

    }


    /**
     * Logging method.
     *
     * @param string $message Log message.
     * @param string $level Optional. Default 'info'. Possible values:
     *                      emergency|alert|critical|error|warning|notice|info|debug.
     */
    public static function log($message, $level = 'info', $source = 'main')
    {
        if (defined('DGWT_WCAS_DEBUG') && DGWT_WCAS_DEBUG === true) {
            if (empty(self::$log)) {
                self::$log = wc_get_logger();
            }
            self::$log->log($level, $message, array('source' => 'dgwt-wcas-' . $source));
        }
    }

    /**
     * Get readable format of memory
     *
     * @param int $bytes
     *
     * @return string
     */
    public static function getReadableMemorySize($bytes)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . $unit[$i];
    }

    /**
     * Get pro icon/label
     *
     * @param string $label
     * @param string $type
     * @param string $headerSubtitle
     *
     * @return string
     */
    public static function getSettingsProLabel($label, $type = 'header', $headerSubtitle = '')
    {
        $html = '';

        switch ($type) {
            case 'header':
                if ( ! empty($headerSubtitle)) {
                    $label = '<span class="dgwt-wcas-pro-header__subtitle">' . $label . '</span><span class="dgwt-wcas-pro-header__subtitle--text">' . $headerSubtitle . '</span>';
                }
                $html .= '<div class="dgwt-wcas-row dgwt-wcas-pro-header"><span class="dgwt-wcas-pro-label">' . $label . '</span><span class="dgwt-wcas-pro-suffix">' . __('Pro', 'ajax-search-for-woocommerce') . '</span></div>';
                break;
            case 'option-label':
                $html .= '<div class="dgwt-wcas-row dgwt-wcas-pro-field"><span class="dgwt-wcas-pro-label">' . $label . '</span><span class="dgwt-wcas-pro-suffix">' . __('Pro', 'ajax-search-for-woocommerce') . '</span></div>';
                break;
        }

        return $html;
    }

    /**
     * Calc score for searched
     *
     * @param string $searched
     * @param string $string eg. product title
     * @param array $args
     *
     * @return int
     */
    public static function calcScore($searched, $string, $args = array())
    {

        $default = array(
            'check_similarity' => true,
            'check_position'   => true,
            'score_containing' => 50
        );
        $args    = array_merge($default, $args);

        $score    = 0;
        $searched = strtolower($searched);
        $string   = strtolower($string);

        if ($args['check_similarity']) {
            $m = similar_text($searched, $string, $percent);

            $score = $score + $percent;
        }

        $pos = strpos($string, $searched);

        // Add score based on substring position
        if ($pos !== false) {
            $score += $args['score_containing']; // Bonus for contained substring

            // Bonus for substring position
            if ($args['check_position']) {
                $posBonus = (100 - ($pos * 100) / strlen($string)) / 2;
                $score    += $posBonus;
            }
        }

        return $score;
    }

    /**
     * Sorting by score
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    public static function cmpSimilarity($a, $b)
    {
        $scoreA = 0;
        $scoreB = 0;

        if (is_object($a)) {
            $scoreA = $a->score;
            $scoreB = $b->score;
        }

        if (is_array($a)) {
            $scoreA = $a['score'];
            $scoreB = $b['score'];
        }

        if ($scoreA == $scoreB) {
            return 0;
        }

        return ($scoreA < $scoreB) ? 1 : -1;
    }

    /**
     * Get taxonomy parents
     *
     * @param int $term_id
     * @param string $taxonomy
     *
     * @return string
     */

    public static function getTermBreadcrumbs($termID, $taxonomy, $visited = array(), $exclude = array())
    {

        $chain     = '';
        $separator = ' > ';

        $parent = get_term($termID, $taxonomy);

        if (empty($parent) || ! isset($parent->name)) {
            return '';
        }

        $name = $parent->name;

        if ($parent->parent && ($parent->parent != $parent->term_id) && ! in_array($parent->parent, $visited)) {
            $visited[] = $parent->parent;
            $chain     .= self::getTermBreadcrumbs($parent->parent, $taxonomy, $visited);
        }

        if ( ! in_array($parent->term_id, $exclude)) {
            $chain .= $name . $separator;
        }

        return $chain;
    }

    /**
     * Get taxonomies of products attributes
     *
     * @return array
     *
     */
    public static function getAttributesTaxonomies()
    {
        $taxonomies          = array();
        $attributeTaxonomies = wc_get_attribute_taxonomies();
        if ( ! empty($attributeTaxonomies)) {

            foreach ($attributeTaxonomies as $taxonomy) {
                $taxonomies[] = 'pa_' . $taxonomy->attribute_name;
            }
        }

        return $taxonomies;
    }

    /**
     *
     */
    public static function canInstallPremium()
    {

    }

    /**
     * Get indexer demo HTML
     *
     * @return string
     */
    public static function indexerDemoHtml()
    {
        $html = '';

        ob_start();

        include DGWT_WCAS_DIR . 'partials/admin/indexer-header-demo.php';

        $html .= ob_get_clean();

        return $html;
    }

    /**
     * Get features HTML
     *
     * @return string
     */
    public static function featuresHtml()
    {
        $html = '';

        ob_start();

        include DGWT_WCAS_DIR . 'partials/admin/features.php';

        $html .= ob_get_clean();

        return $html;
    }

    /**
     * Get pro startet info - HTML
     *
     * @return string
     */
    public static function proStarterHTML()
    {
        $html = '';

        ob_start();

        include DGWT_WCAS_DIR . 'partials/admin/pro-starter.php';

        $html .= ob_get_clean();

        return $html;
    }

    /**
     * Log by WooCommerce logger
     *
     * @return void
     */
    public static function WCLog($level = 'debug', $message = '')
    {
        $logger  = wc_get_logger();
        $context = array('source' => 'ajax-search-for-woocommerce');
        $logger->log($level, $message, $context);
    }

}