<?php

namespace DgoraWcas\Engines\WordPressNative;

use  DgoraWcas\Product ;
use  DgoraWcas\Helpers ;
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Search
{
    /**
     * Suggestions limit
     * int
     */
    private  $limit ;
    /**
     * Description limit
     * int
     */
    private  $descLimit = 130 ;
    /**
     * Empty slots
     * int
     */
    private  $slots ;
    public function __construct()
    {
        $this->limit = absint( DGWT_WCAS()->settings->get_opt( 'suggestions_limit', 10 ) );
        $this->slots = $this->limit;
        // Free slots for the results. Default 10
        add_filter(
            'posts_search',
            array( $this, 'searchFilters' ),
            501,
            2
        );
        add_filter(
            'posts_where',
            array( $this, 'fixWooExcerptSearch' ),
            100,
            2
        );
        add_filter(
            'posts_distinct',
            array( $this, 'search_distinct' ),
            501,
            2
        );
        add_filter(
            'posts_join',
            array( $this, 'searchFiltersJoin' ),
            501,
            2
        );
        add_filter(
            'pre_get_posts',
            array( $this, 'overwriteSearchPage' ),
            109900,
            1
        );
        add_filter(
            'posts_search',
            array( $this, 'disableSearchFiltersOnPostsIn' ),
            10,
            2
        );
        // Search results ajax action
        
        if ( DGWT_WCAS_WC_AJAX_ENDPOINT ) {
            add_action( 'wc_ajax_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
        } else {
            add_action( 'wp_ajax_nopriv_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
            add_action( 'wp_ajax_' . DGWT_WCAS_SEARCH_ACTION, array( $this, 'getSearchResults' ) );
        }
    
    }
    
    /**
     * Get search results via ajax
     */
    public function getSearchResults()
    {
        global  $woocommerce ;
        $start = microtime( true );
        if ( !defined( 'DGWT_WCAS_AJAX' ) ) {
            define( 'DGWT_WCAS_AJAX', true );
        }
        $output = array();
        $results = array();
        $keyword = '';
        $remote = false;
        // Compatibile with v1.1.7
        if ( !empty($_REQUEST['dgwt_wcas_keyword']) ) {
            $keyword = sanitize_text_field( $_REQUEST['dgwt_wcas_keyword'] );
        }
        if ( !empty($_REQUEST['s']) ) {
            $keyword = sanitize_text_field( $_REQUEST['s'] );
        }
        if ( !empty($_REQUEST['remote']) ) {
            $remote = true;
        }
        $keyword = apply_filters( 'dgwt/wcas/phrase', $keyword );
        /* SEARCH IN WOO CATEGORIES */
        
        if ( !$remote && DGWT_WCAS()->settings->get_opt( 'show_matching_categories' ) === 'on' ) {
            $categories = $this->get_categories( $keyword );
            $results = array_merge( $categories, $results );
            // Update slots
            $this->slots = $this->slots - count( $categories );
        }
        
        /* END SEARCH IN WOO CATEGORIES */
        /* SEARCH IN WOO TAGS */
        
        if ( !$remote && DGWT_WCAS()->settings->get_opt( 'show_matching_tags' ) === 'on' && $this->slots > 0 ) {
            $tags = $this->get_tags( $keyword );
            $results = array_merge( $tags, $results );
            // Update slots
            $this->slots = $this->slots - count( $tags );
        }
        
        /* END SEARCH IN WOO TAGS */
        // Leave at least 3 slots for products
        // @TODO Think of a better way where here is a lot of taxonomy results
        
        if ( $this->slots < 3 ) {
            $j = count( $results ) - 0;
            for ( $i = $this->slots ;  $i < 3 ;  $i++ ) {
                unset( $results[$j] );
                $j--;
            }
            $this->slots = 3;
        }
        
        // Continue searching in products if there are room in the slots
        /* SEARCH IN PRODUCTS */
        $displayed = 0;
        
        if ( $this->slots > 0 || $remote ) {
            $args = array(
                's'                   => $keyword,
                'posts_per_page'      => -1,
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby'             => 'relevance',
                'order'               => 'DESC',
                'suppress_filters'    => false,
            );
            // Backward compatibility WC < 3.0
            
            if ( Helpers::compare_wc_version( '3.0', '<' ) ) {
                $args['meta_query'] = $this->get_meta_query();
            } else {
                $args['tax_query'] = $this->get_tax_query();
            }
            
            $args = apply_filters( 'dgwt_wcas_products_args', $args );
            // deprecated since v1.2.0
            $args = apply_filters( 'dgwt/wcas/search_query/args', $args );
            $products = get_posts( $args );
            
            if ( !empty($products) ) {
                $orderedProducts = array();
                $i = 0;
                foreach ( $products as $post ) {
                    
                    if ( $remote ) {
                        $orderedProducts[$i] = new \stdClass();
                        $orderedProducts[$i]->ID = $post->ID;
                    } else {
                        $orderedProducts[$i] = $post;
                    }
                    
                    $orderedProducts[$i]->score = Helpers::calcScore( $keyword, $post->post_title );
                    $i++;
                }
                // Sort by relevance
                usort( $orderedProducts, array( 'DgoraWcas\\Helpers', 'cmpSimilarity' ) );
                // Response for remote requests
                
                if ( $remote ) {
                    $output['suggestions'] = $orderedProducts;
                    $output['time'] = number_format(
                        microtime( true ) - $start,
                        2,
                        '.',
                        ''
                    ) . ' sec';
                    echo  json_encode( apply_filters( 'dgwt/wcas/page_search_results/output', $output ) ) ;
                    die;
                }
                
                $relevantProducts = array();
                foreach ( $orderedProducts as $post ) {
                    $product = new Product( $post );
                    $scoreDebug = '';
                    if ( defined( 'DGWT_WCAS_DEBUG' ) && DGWT_WCAS_DEBUG ) {
                        $scoreDebug = ' (score:' . (int) $post->score . ')';
                    }
                    $r = array(
                        'post_id' => $product->getID(),
                        'value'   => wp_strip_all_tags( $product->getName() ) . $scoreDebug,
                        'url'     => $product->getPermalink(),
                    );
                    // Get thumb HTML
                    if ( DGWT_WCAS()->settings->get_opt( 'show_product_image' ) === 'on' ) {
                        $r['thumb_html'] = $product->getThumbnail();
                    }
                    // Get price
                    if ( DGWT_WCAS()->settings->get_opt( 'show_product_price' ) === 'on' ) {
                        $r['price'] = $product->getPriceHTML();
                    }
                    // Get description
                    
                    if ( DGWT_WCAS()->settings->get_opt( 'show_product_desc' ) === 'on' ) {
                        if ( DGWT_WCAS()->settings->get_opt( 'show_details_box' ) === 'on' ) {
                            $this->descLimit = 60;
                        }
                        $r['desc'] = Helpers::get_product_desc( $product->getID(), $this->descLimit );
                    }
                    
                    // Get SKU
                    if ( DGWT_WCAS()->settings->get_opt( 'show_product_sku' ) === 'on' ) {
                        $r['sku'] = $product->getSKU();
                    }
                    // Is on sale
                    //					if ( DGWT_WCAS()->settings->get_opt( 'show_sale_badge' ) === 'on' ) {
                    //						$r[ 'on_sale' ] = $product->is_on_sale();
                    //					}
                    // Is featured
                    //					if ( DGWT_WCAS()->settings->get_opt( 'show_featured_badge' ) === 'on' ) {
                    //						$r[ 'featured' ] = $product->is_featured();
                    //					}
                    $relevantProducts[] = apply_filters( 'dgwt/wcas/search_results/products', $r, $product );
                    $this->slots--;
                    $displayed++;
                    if ( empty($this->slots) ) {
                        break;
                    }
                }
            }
            
            wp_reset_postdata();
        }
        
        /* END SEARCH IN PRODUCTS */
        if ( !empty($relevantProducts) ) {
            $results = array_merge( $results, $relevantProducts );
        }
        if ( empty($results) ) {
            // Show nothing on empty results
            //@todo show 'No results' as option
            
            if ( $remote ) {
                $results[] = array(
                    'ID' => 0,
                );
            } else {
                $results[] = array(
                    'value' => '',
                );
            }
        
        }
        $total = ( isset( $products ) ? count( $products ) : 0 );
        $output['suggestions'] = $results;
        // Show more
        if ( $displayed < $total ) {
            $output['suggestions'][] = array(
                'value' => '',
                'total' => $total,
                'url'   => add_query_arg( array(
                's'         => $keyword,
                'post_type' => 'product',
                'dgwt_wcas' => '1',
            ), home_url() ),
                'type'  => 'more_products',
            );
        }
        $output['total'] = $total;
        $output['time'] = number_format(
            microtime( true ) - $start,
            2,
            '.',
            ''
        ) . ' sec';
        echo  json_encode( apply_filters( 'dgwt/wcas/search_results/output', $output ) ) ;
        die;
    }
    
    /**
     * Get meta query
     * For WooCommerce < 3.0
     *
     * return array
     */
    private function get_meta_query()
    {
        $meta_query = array(
            'relation' => 'AND',
            1          => array(
            'key'     => '_visibility',
            'value'   => array( 'search', 'visible' ),
            'compare' => 'IN',
        ),
            2          => array(
            'relation' => 'OR',
            array(
            'key'     => '_visibility',
            'value'   => array( 'search', 'visible' ),
            'compare' => 'IN',
        ),
        ),
        );
        // Exclude out of stock products from suggestions
        if ( DGWT_WCAS()->settings->get_opt( 'exclude_out_of_stock' ) === 'on' ) {
            $meta_query[] = array(
                'key'     => '_stock_status',
                'value'   => 'outofstock',
                'compare' => 'NOT IN',
            );
        }
        return $meta_query;
    }
    
    /**
     * Get tax query
     * For WooCommerce >= 3.0
     *
     * return array
     */
    private function get_tax_query()
    {
        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
        $tax_query = array(
            'relation' => 'AND',
        );
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => $product_visibility_term_ids['exclude-from-search'],
            'operator' => 'NOT IN',
        );
        // Exclude out of stock products from suggestions
        if ( DGWT_WCAS()->settings->get_opt( 'exclude_out_of_stock' ) === 'on' ) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_term_ids['outofstock'],
                'operator' => 'NOT IN',
            );
        }
        return $tax_query;
    }
    
    /**
     * Search for matching category
     *
     * @param string $keyword
     *
     * @return array
     */
    public function get_categories( $keyword )
    {
        $results = array();
        $args = array(
            'taxonomy' => 'product_cat',
        );
        $product_categories = get_terms( 'product_cat', $args );
        // Compare keyword and term name
        $i = 0;
        foreach ( $product_categories as $cat ) {
            
            if ( $i < $this->limit ) {
                $cat_name = html_entity_decode( $cat->name );
                $pos = strpos( strtolower( $cat_name ), strtolower( $keyword ) );
                
                if ( $pos !== false ) {
                    $results[$i] = array(
                        'term_id'     => $cat->term_id,
                        'taxonomy'    => 'product_cat',
                        'value'       => preg_replace( sprintf( "/(%s)/", $keyword ), "\$1", $cat_name ),
                        'url'         => get_term_link( $cat, 'product_cat' ),
                        'breadcrumbs' => Helpers::getTermBreadcrumbs(
                        $cat->term_id,
                        'product_cat',
                        array(),
                        array( $cat->term_id )
                    ),
                    );
                    // Fix: Remove last separator
                    if ( !empty($results[$i]['breadcrumbs']) ) {
                        $results[$i]['breadcrumbs'] = mb_substr( $results[$i]['breadcrumbs'], 0, -3 );
                    }
                    $i++;
                }
            
            }
        
        }
        return $results;
    }
    
    /**
     * Extend research in the Woo tags
     *
     * @param strong $keyword
     *
     * @return array
     */
    public function get_tags( $keyword )
    {
        $results = array();
        $args = array(
            'taxonomy' => 'product_tag',
        );
        $product_tags = get_terms( 'product_tag', $args );
        // Compare keyword and term name
        $i = 0;
        foreach ( $product_tags as $tag ) {
            
            if ( $i < $this->limit ) {
                $tag_name = html_entity_decode( $tag->name );
                $pos = strpos( strtolower( $tag_name ), strtolower( $keyword ) );
                
                if ( $pos !== false ) {
                    $results[$i] = array(
                        'term_id'  => $tag->term_id,
                        'taxonomy' => 'product_tag',
                        'value'    => preg_replace( sprintf( "/(%s)/", $keyword ), "\$1", $tag_name ),
                        'url'      => get_term_link( $tag, 'product_tag' ),
                        'parents'  => '',
                    );
                    $i++;
                }
            
            }
        
        }
        return $results;
    }
    
    /**
     * Search in extra fields
     *
     * @param string $search SQL
     *
     * @return string prepared SQL
     */
    public function searchFilters( $search, $wp_query )
    {
        global  $wpdb ;
        
        if ( empty($search) || is_admin() ) {
            return $search;
            // skip processing - there is no keyword
        }
        
        
        if ( $this->is_ajax_search() ) {
            $q = $wp_query->query_vars;
            
            if ( $q['post_type'] !== 'product' ) {
                return $search;
                // skip processing
            }
            
            $n = ( !empty($q['exact']) ? '' : '%' );
            $search = $searchand = '';
            if ( !empty($q['search_terms']) ) {
                foreach ( (array) $q['search_terms'] as $term ) {
                    $term = esc_sql( $wpdb->esc_like( $term ) );
                    $search .= "{$searchand} (";
                    // Search in title
                    $search .= "({$wpdb->posts}.post_title LIKE '{$n}{$term}{$n}')";
                    // Search in content
                    if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_content' ) === 'on' ) {
                        $search .= " OR ({$wpdb->posts}.post_content LIKE '{$n}{$term}{$n}')";
                    }
                    // Search in excerpt
                    if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_excerpt' ) === 'on' ) {
                        $search .= " OR ({$wpdb->posts}.post_excerpt LIKE '{$n}{$term}{$n}')";
                    }
                    // Search in SKU
                    if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_sku' ) === 'on' ) {
                        $search .= " OR (dgwt_wcasmsku.meta_key='_sku' AND dgwt_wcasmsku.meta_value LIKE '{$n}{$term}{$n}')";
                    }
                    $search .= ")";
                    $searchand = ' AND ';
                }
            }
            
            if ( !empty($search) ) {
                $search = " AND ({$search}) ";
                if ( !is_user_logged_in() ) {
                    $search .= " AND ({$wpdb->posts}.post_password = '') ";
                }
            }
        
        }
        
        return $search;
    }
    
    /**
     * @param $where
     *
     * @return string
     */
    public function search_distinct( $where )
    {
        if ( $this->is_ajax_search() ) {
            return 'DISTINCT';
        }
        return $where;
    }
    
    /**
     * Join the postmeta column in the search posts SQL
     */
    public function searchFiltersJoin( $join, $query )
    {
        global  $wpdb ;
        
        if ( empty($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'product' ) {
            return $join;
            // skip processing
        }
        
        if ( $this->is_ajax_search() && !is_admin() ) {
            if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_sku' ) === 'on' ) {
                $join .= " INNER JOIN {$wpdb->postmeta} AS dgwt_wcasmsku ON ( {$wpdb->posts}.ID = dgwt_wcasmsku.post_id )";
            }
        }
        return $join;
    }
    
    /**
     * Corrects the search by excerpt if necessary.
     * WooCommerce adds search in excerpt by defaults and this should be corrected.
     *
     * @since 1.1.4
     *
     * @param string $where
     *
     * @return string
     */
    public function fixWooExcerptSearch( $where )
    {
        global  $wp_the_query ;
        // If this is not a WC Query, do not modify the query
        if ( empty($wp_the_query->query_vars['wc_query']) || empty($wp_the_query->query_vars['s']) ) {
            return $where;
        }
        if ( DGWT_WCAS()->settings->get_opt( 'search_in_product_excerpt' ) !== 'on' ) {
            $where = preg_replace( "/OR \\(post_excerpt\\s+LIKE\\s*(\\'\\%[^\\%]+\\%\\')\\)/", "", $where );
        }
        return $where;
    }
    
    /**
     * Get taxonomy parent
     *
     * @param int $term_id
     * @param string $taxonomy
     *
     * @return string
     */
    private function get_taxonomy_parent_string(
        $term_id,
        $taxonomy,
        $visited = array(),
        $exclude = array()
    )
    {
        $chain = '';
        $separator = ' > ';
        $parent = get_term( $term_id, $taxonomy );
        if ( empty($parent) || !isset( $parent->name ) ) {
            return '';
        }
        $name = $parent->name;
        
        if ( $parent->parent && $parent->parent != $parent->term_id && !in_array( $parent->parent, $visited ) ) {
            $visited[] = $parent->parent;
            $chain .= $this->get_taxonomy_parent_string( $parent->parent, $taxonomy, $visited );
        }
        
        if ( !in_array( $parent->term_id, $exclude ) ) {
            $chain .= $name . $separator;
        }
        return $chain;
    }
    
    public function overwriteSearchPage( $query )
    {
        if ( $query->is_search() ) {
            
            if ( isset( $query->query_vars['s'] ) && isset( $_REQUEST['dgwt_wcas'] ) && strlen( $query->query_vars['s'] ) >= 3 ) {
                $s = $query->query_vars['s'];
                $baseUrl = home_url() . strtok( $_SERVER["REQUEST_URI"], '?' ) . \WC_AJAX::get_endpoint( DGWT_WCAS_SEARCH_ACTION );
                $url = add_query_arg( array(
                    's'      => $s,
                    'remote' => 1,
                ), $baseUrl );
                $ids = array();
                $correctResponse = false;
                $r = wp_remote_retrieve_body( wp_remote_get( $url, array(
                    'timeout' => 120,
                ) ) );
                $decR = json_decode( $r );
                if ( json_last_error() == JSON_ERROR_NONE ) {
                    
                    if ( is_object( $decR ) && property_exists( $decR, 'suggestions' ) && is_array( $decR->suggestions ) ) {
                        $correctResponse = true;
                        foreach ( $decR->suggestions as $suggestion ) {
                            $ids[] = $suggestion->ID;
                        }
                    }
                
                }
                
                if ( $correctResponse ) {
                    $query->set( 'orderby', 'post__in' );
                    $query->set( 'post__in', $ids );
                }
            
            }
        
        }
    }
    
    public function disableSearchFiltersOnPostsIn( $search, $query )
    {
        
        if ( isset( $_REQUEST['s'] ) && isset( $_REQUEST['dgwt_wcas'] ) ) {
            $post__in = $query->get( 'post__in' );
            if ( !empty($post__in) ) {
                $search = '';
            }
        }
        
        return $search;
    }
    
    /**
     * Check if is ajax search processing
     *
     * @since 1.1.3
     *
     * @return bool
     */
    public function is_ajax_search()
    {
        if ( defined( 'DGWT_WCAS_AJAX' ) && DGWT_WCAS_AJAX ) {
            return true;
        }
        return false;
    }

}