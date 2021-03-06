<?php

/*
Plugin Name: Custom Product Import Excel
Description: Product and variation uploading
Version: 1.0
Author: PK SOL
Author URI: https://www.pksol.com
*/


add_action('admin_menu', 'gp_create_menu');
function gp_create_menu() {

    add_menu_page('Product Importer', 'Product Importer', 'administrator', 'custom_product_importer', 'custom_product_importer_handler', 'dashicons-upload');

}

function custom_product_importer_handler() { 

    $plugin_url = plugins_url('/custom-product-import-excel');

    global $wpdb;

    $prefix = $wpdb->prefix;
    
    $brands_query = $wpdb->get_results("SELECT * FROM {$prefix}tecdoc_products WHERE `status` = 'not_imported' GROUP BY brand ", OBJECT);    
    $brands = '';

    foreach ($brands_query as $key => $brand) {
        $brands .= '<option val="'.$brand->brand.'">'. ucwords($brand->brand) .'</option>';
    }

    $years_query = $wpdb->get_results("SELECT * FROM {$prefix}tecdoc_products WHERE `status` = 'not_imported' GROUP BY model", OBJECT);
    $years = '';

    foreach ($years_query as $key => $year) {
        $years .= '<option val="'.$year->model.'">'. $year->model .'</option>';
    }


    $results_query = $wpdb->get_results("SELECT * FROM {$prefix}tecdoc_products WHERE `status` = 'not_imported'", OBJECT);
    $rows = '';

    foreach ($results_query as $key => $row) {

        $description = "
            <strong>Height: </strong>  $row->height,
            <strong>Width: </strong> $row->width,
            <strong>Doors: </strong> $row->doors, <br>
            <strong>Brake: </strong> $row->brake,
            <strong>Engine: </strong> $row->engine,
            <strong>Fuel Capacity: </strong> $row->fuel_capacity
        ";

        $rows .= '<tr>
            <td>'.ucwords($row->name).'</td>
            <td>'.ucwords($row->brand).'</td>
            <td>'.$row->model.'</td>
            <td>'.$description.'</td>
            <td>
                <form class="adding_to_woo">                    
                    <input type="hidden" name="name" value="'.$row->name.'">
                    <input type="hidden" name="brand" value="'.$row->brand.'">
                    <input type="hidden" name="model" value="'.$row->model.'">
                    <input type="hidden" name="height" value="'.$row->height.'">
                    <input type="hidden" name="width" value="'.$row->width.'">
                    <input type="hidden" name="doors" value="'.$row->doors.'">
                    <input type="hidden" name="seats" value="'.$row->seats.'">
                    <input type="hidden" name="brake" value="'.$row->brake.'">
                    <input type="hidden" name="engine" value="'.$row->engine.'">
                    <input type="hidden" name="fuel_capacity" value="'.$row->fuel_capacity.'">
                    <input type="text" name="price" class="tc_price" placeholder="Enter Price">
                    <br><button class="tc_import" type="submit">+ Add</button>
                </form>
            </td>
        </tr>';
    }

    echo '
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <link rel="stylesheet" href="'.$plugin_url.'/css/main.css?time='.time().'">

        <div class="s003">

            <h1 class="product-search">Search Product</h1>

            <form class="search-submit-form">
            <div class="inner-form">
            <div class="input-field first-wrap">
                <div class="input-select">
                <select data-trigger="" name="brand-input" id="brand-input">
                    <option placeholder="">Brand</option>
                    '.$brands.'
                </select>
                </div>
            </div>

            <div class="input-field first-wrap">
                <div class="input-select">
                <select data-trigger="" name="model-input" id="model-input">
                    <option placeholder="">Model</option>
                    '.$years.'
                </select>
                </div>
            </div>

            <div class="input-field second-wrap">
                <input type="text" placeholder="Enter Name" id="search-input" />
            </div>
            
            <div class="input-field third-wrap">
                <button class="btn-search" type="submit">
                <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                </svg>
                </button>
            </div>

            </div>
        </form>

        <br><br>

        <div class="data">
            <table id="table-data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    '.$rows.'
                </tbody>
                
            </table>
        </div>


        
    </div>    
    ';
}

add_action( 'admin_footer', 'admin_footer_script' );

function admin_footer_script() {

    $plugin_url = plugins_url('/custom-product-import-excel');

    echo '

        <style>
            th.sorting_disabled, table.dataTable tbody th, table.dataTable tbody td {
                border: 1px solid #ddd;
                text-align: center;
            }
            table.dataTable thead th, table.dataTable thead td {
                border-bottom: 1px solid #ddd;
            }
            .data {
                margin-right: 20px;
            }

            .tc_import {
                width: 23%;
                background: none;
                border: 0;
                background: #4CAF50;
                color: #fff;
                padding: 3px 2px;
                font-size: 11px;
                margin-top: 5px;
                outline: none;
                cursor: pointer;
            }

            input.tc_price {
                width: 45%;
                font-size: 11px;
                text-align: center;
            }

            #table-data_filter {
                visibility: hidden;
            }

        </style>

        <script src="'.$plugin_url.'/js/extention/choices.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        
        <script>

            ajaxurl = "'.get_site_url().'/wp-admin/admin-ajax.php";

            $(document).ready(function() {

       
                const choices = new Choices("[data-trigger]",
                {
                    searchEnabled: false,
                    itemSelectText: "",
                });

                var tables = $("#table-data").DataTable({
                    searching: true,
                    ordering:  false,
                    "lengthChange":   false
                });

                $(".search-submit-form").submit(function(e){
                    
                    e.preventDefault();

                    var brand = $("#brand-input").val();
                    var model = $("#model-input").val();
                    var search = $("#search-input").val();

                    if(brand != "" && model != "" && search != "") {

                        tables
                        .column(0).search( search )
                        .column(1).search( brand )
                        .column(2).search( model )
                        .draw();
                        
                    } else {
                        alert("Please fill the search parameters Correctly");
                    } 
                    
                });

                $(document).on("submit", ".adding_to_woo", function(e){
                    e.preventDefault();

                    var $this = $(this);
                    var rawData = $this.serializeArray();

                    var submitButton = $this.find(".tc_import");
                    
                    if(rawData[10].value == "") {

                        alert("Please Input Price First");

                    } else {

                        var data = {
                            action: "inserting_data",
                            data: rawData
                        };

                        submitButton.html("Adding...").attr("disabled", "disabled");

                        $.post(ajaxurl, data, function (response) {
                            submitButton.html("added");
                            $this.parent().parent().fadeOut("Fast");
                            $this.remove();
                        });

                    }

                });


            });
            
            </script>
    ';
}

add_action( 'wp_ajax_nopriv_inserting_data', 'inserting_data' );
add_action( 'wp_ajax_inserting_data', 'inserting_data' );


function inserting_data() { 
    
    $data = $_POST['data'];

    $name = ucwords($data[0]['value']);
    $price = (int) $data[10]['value'];

    $post_id = wp_insert_post( array(
        'post_title' => $name,
        'post_content' => $name,
        'post_status' => 'publish',
        'post_type' => "product",
    ) );

    wp_set_object_terms( $post_id, 'simple', 'product_type' );

    update_post_meta( $post_id, '_visibility', 'visible' );
    update_post_meta( $post_id, '_stock_status', 'instock');
    update_post_meta( $post_id, 'total_sales', '0' );
    update_post_meta( $post_id, '_downloadable', 'no' );
    update_post_meta( $post_id, '_virtual', 'yes' );
    update_post_meta( $post_id, '_regular_price', $price );
    update_post_meta( $post_id, '_sale_price', '' );
    update_post_meta( $post_id, '_purchase_note', '' );
    update_post_meta( $post_id, '_featured', 'no' );
    update_post_meta( $post_id, '_weight', '' );
    update_post_meta( $post_id, '_length', '' );
    update_post_meta( $post_id, '_width', '' );
    update_post_meta( $post_id, '_height', '' );
    update_post_meta( $post_id, '_sku', '' );
    update_post_meta( $post_id, '_product_attributes', array() );
    update_post_meta( $post_id, '_sale_price_dates_from', '' );
    update_post_meta( $post_id, '_sale_price_dates_to', '' );
    update_post_meta( $post_id, '_price', $price );
    update_post_meta( $post_id, '_sold_individually', '' );
    update_post_meta( $post_id, '_manage_stock', 'no' );
    update_post_meta( $post_id, '_backorders', 'no' );
    update_post_meta( $post_id, '_stock', '' );

    $atts = [];
    foreach ($data as $key => $values) {

        if($key != 0 && $key != 10) {
            $term_added = wp_insert_term($values['value'], 'pa_'.$values['name']);

            $term_taxonomy_ids = wp_set_object_terms($post_id, strtolower($values['value']), 'pa_'.$values['name'], true);
            
            $attt = array(
                'name' => 'pa_'.$values['name'],
                'value' => strtolower($values['value']),
                'is_visible' => '1',
                'is_variation' => '0',
                'is_taxonomy' => '1'
            );


            array_push($atts, $attt);

        }

    }

    update_post_meta($post_id, '_product_attributes', $atts);

    die();

}



