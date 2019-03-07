<?php

namespace DgoraWcas;


class Product
{
    private $productID = 0;
    private $wcProduct = null;
    private $variations = array();

    public function __construct($product)
    {
        if ( ! empty($product) && is_object($product) && is_a($product, 'WC_Product')) {
            $this->productID = $product->get_id();
            $this->wcProduct = $product;
        }

        if ( ! empty($product) && is_object($product) && is_a($product, 'WP_Post')) {
            $this->productID = absint($product->ID);
            $this->wcProduct = wc_get_product($product);
        }

        if (is_numeric($product) && 'product' === get_post_type($product)) {
            $this->productID = absint($product);
            $this->wcProduct = wc_get_product($product);
        }
    }

    /**
     * Get product ID (post_id)
     * @return INT
     */
    public function getID()
    {
        return $this->productID;
    }

    /**
     * Get created date
     *
     * @return mixed
     */
    public function getCreatedDate()
    {
        $date = $this->wcProduct->get_date_created();
        if ( ! $date) {
            $date = '0000-00-00 00:00:00';
        }

        return $date;
    }

    /**
     * Get product name
     * @return string
     */
    public function getName()
    {
        return $this->wcProduct->get_name();
    }

    /**
     * Get prepared product description
     *
     * @param string $type full|short|suggestions
     *
     * @return string
     */
    public function getDescription($type = 'full')
    {

        $output = '';

        if ($type === 'full') {
            $output = $this->wcProduct->get_description();
        }

        if ($type === 'short') {
            $output = $this->wcProduct->get_short_description();
        }

        if ($type === 'suggestons') {

            $desc = $this->wcProduct->get_short_description();

            if (empty($desc)) {
                $desc = $this->wcProduct->get_description();
            }

            if ( ! empty($desc)) {
                $output = Helpers::strCut(wp_strip_all_tags($desc), 120);
                $output = html_entity_decode($output);
            }
        }

        return $output;

    }

    /**
     * Get product permalink
     * @return string
     */
    public function getPermalink()
    {
        return $this->wcProduct->get_permalink();
    }

    /**
     * Get product thumbnail url
     * @return string
     */
    public function getThumbnailSrc()
    {
        $src = '';

        $imageID = $this->wcProduct->get_image_id();

        if ( ! empty($imageID)) {
            $imageSrc = wp_get_attachment_image_src($imageID, 'dgwt-wcas-product-suggestion');

            if ( is_array($imageSrc) && ! empty($imageSrc[0])) {
                $src = $imageSrc[0];
            }
        }

        if(empty($src)){
            $src = wc_placeholder_img_src();
        }

        return $src;
    }

    /**
     * Get product thumbnail
     * @return string
     */
    public function getThumbnail()
    {
        return '<img src="' . $this->getThumbnailSrc() . '" alt="' . $this->getName() . '" />';
    }


    /**
     * Get HTML code with the product price
     * @return string
     */
    public function getPriceHTML()
    {
        return $this->wcProduct->get_price_html();
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->wcProduct->get_price();
    }

    /**
     * Get average rating
     *
     * @return float
     */
    public function getAverageRating()
    {
        return $this->wcProduct->get_average_rating();
    }

    /**
     * Get review count
     *
     * @return int
     */
    public function getReviewCount()
    {
        return $this->wcProduct->get_review_count();
    }

    /**
     * Get total sales
     *
     * @return int
     */
    public function getTotalSales()
    {
        return $this->wcProduct->get_total_sales();
    }

    /**
     * Get SKU
     * @return string
     */
    public function getSKU()
    {
        return $this->wcProduct->get_sku();
    }

    /**
     * Get available variations
     * @return array
     */
    public function getAvailableVariations()
    {

        if (empty($this->variations) && is_a($this->wcProduct, 'WC_Product_Variable')) {
            return $this->wcProduct->get_available_variations();
        }

        return $this->variations;

    }

    /**
     * Get all SKUs for variations
     * @return array
     */
    public function getVariationsSKUs()
    {
        $skus = array();

        $variations = $this->getAvailableVariations();

        foreach ($variations as $variation) {

            if (is_array($variation) && ! empty($variation['sku'])) {
                $skus[] = sanitize_text_field($variation['sku']);
            }
        }

        return $skus;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes($onlyNames = false)
    {

        $attributes          = array();
        $attributeTaxonomies = wc_get_attribute_taxonomies();
        if ( ! empty($attributeTaxonomies)) {

            foreach ($attributeTaxonomies as $taxonomy) {

                $terms = get_the_terms($this->getID(), 'pa_' . $taxonomy->attribute_name);

                if (is_array($terms)) {
                    if ( ! $onlyNames) {
                        $attributes[$taxonomy->attribute_name] = array();
                    }
                    foreach ($terms as $term) {
                        if ( ! $onlyNames) {
                            $attributes[$taxonomy->attribute_name][] = array(
                                'name' => $term->name
                            );
                        } else {
                            $attributes[] = $term->name;
                        }
                    }
                }


            }
        }


        return $attributes;
    }

    /**
     * Check, if class is initialized correctly
     * @return bool
     */
    public function isValid()
    {
        $isValid = false;

        if (is_a($this->wcProduct, 'WC_Product')) {
            $isValid = true;
        }

        return $isValid;
    }

    /**
     * WooCommerce raw product object
     *
     * @return object
     */
    public function getWooObject()
    {
        return $this->wcProduct;
    }


}