=== Ajax Search for WooCommerce  ===
Contributors: damian-gora
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LD2ALVRLXPZPC
Tags: woocomerce search, ajax search, live search, product search, woocommerce
Requires at least: 3.8
Tested up to: 5.1
Requires PHP: 5.5
Stable tag: 1.3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Help users easily find and discover products in your store using Ajax Search for WooCommerce – a highly customizable live search plugin.

== Description ==

The plugin allows your customers to search products easily and quickly. It will display the results instantly while typing in an inputbox.
You can display the WooCommerce AJAX search form anywhere on the page.

Just enter a few letters and the products which best match your query will appear. 
Suggestions can be displayed in a simple form (names of the products only) or in an extended form (includes photos, prices, descriptions, extended information etc.).

Ajax Search for WooCommerce has been designed to enhance user search experience to the maximum.

= Free =
This plugin is completely free of charge and provides the whole range of functions which are included in some paid plugins.
Initially, I created the plugin for my personal use, but I have decided to include new features and make it available to WordPress community.

= Demo =
See how it works on the [DEMO](http://damiangora.com/ajax-search-for-woocommerce) site.


= Features =
* Search in **products titles, descriptions, excerpt or SKU**.
* **Product image** can be displayed for each suggestion
* **Price** can be displayed for each suggestion
* **Description** can be displayed for each suggestion
* **SKU** can be displayed for each suggestion
* The **'add to cart' button with a quantity field** and **extended information** displayed when you hover the mouse over the suggestion
* **Categories and tags** as suggestions
* **Limit** displayed suggestions – you can set your own
* **The minimum number of characters** required to display suggestions – you can set your own
* WPML compatible
* You can set your own **label on the 'search' button**
* You can set your own **preloader image**
* You can set your own **colour scheme** for the 10 main form elements and suggestions

= How to use? =
1. Use shorcode [wcas-search-form] in page/post editor or <?php echo do_shortcode('[wcas-search-form]'); ?> in your Child Theme template files.
2. Go to the "Widgets Screen" and assign widget "Woo Ajax Search" to one of the widget area.

= Feedback =

Any suggestions or comments are welcome. Feel free to contact me using this [contact form](http://damiangora.com/ajax-search-for-woocommerce/contact).

== Installation ==

1. Install the plugin from within the Dashboard or upload the directory `ajax-search-for-woocommerce` and all its contents to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Woo Ajax Search (admin menu) and set your preferences.
4. Use shorcode [wcas-search-form] or go to the Widgets Screen and choose "Woo Ajax Search"

== Screenshots ==

1. Basic suggestions
2. Extra elements
3. Extended suggestions
4. Settings page with colour schemes

== Changelog ==

= 1.3.2, February 16, 2019 =

* ADD: The text "No results" and "See all results..." can be customized in the plugin settings
* ADD: New filters and hooks
* FIX: Hide the "Account" link in the free plugin versions
* FIX: The error with the appearance of the tags suggestion
* FIX: Problem with artificially duplicated search forms occurred in the Mega Menu plugin and some themes.
* CHANGE: Enforcing use "box-sizing: border-box" within the search form
* CHANGE: Updated Freemius SDK

= 1.3.1, January 06, 2019 =
* FIX: PHP error with widget

= 1.3.0, January 06, 2019 =

* ADD: If there are more results than limit, the "See all results..." link will appear
* ADD: Information about the PRO features
* ADD: Breadcrumbs for nested product categories
* FIX: Better synchronization between the ajax search results and the search page
* FIX: Improvements in the scoring system
* FIX: Image placeholder for products without image
* FIX: Add SKU label translatable in the suggestions
* CHANGE: Updated Freemius SDK


= 1.2.1, October 26, 2018 =
* ADD: Storefront support as a option. Allows to replace the native Storefront search form
* FIX: Improving the relevance of search results by adding score system
* FIX: Problem with too big images is some cases
* FIX: Support for HTML entities in the search results
* FIX: Bugs with the blur event on mobile devices


= 1.2.0, August 24, 2018 =
* ADD: Backward compatibility system
* ADD: Support of image size improvements in Woocommerce 3.3
* ADD: Dynamic width of the search form
* ADD: Option to set max width of the search form
* ADD: DISABLE_NAG_NOTICES support for admin notices
* ADD: More hooks for developers
* ADD: Minified version of CSS and JS
* ADD: Label for taxonomy suggestions
* ADD: Quantity input for a add to cart button in the details box
* FIX: Problem with covering suggestions by other HTML elements of themes.
* FIX: Details box in RTL
* FIX: Improvements for the IE browser
* CHANGE: Code refactor for better future development. Composer and PSR-4 support (in part).
* CHANGE: Better settings organization
* CHANGE: Updated Freemius SDK


= 1.1.7, April 22, 2017 =
* FIX: Removed duplicate IDs
* CHANGE: PHP requires tag set to PHP 5.5
* CHANGE: Woocommerce requires tags
* CHANGE: Updated Freemius SDK
* REMOVE: Removed uninstall.php

= 1.1.6, October 01, 2017 =
* FIX: Disappearing some categories and tags in suggestions
* FIX: Hidden products were shown in search

= 1.1.5, September 05, 2017 =
* ADD: Requires PHP tag in readme.txt
* FIX: PHP Fatal error for PHP < 5.3

= 1.1.4, September 03, 2017 =
* ADD: Admin notice if there is no WooCommerce installed
* ADD: Admin notice for better feedback from users
* FIX: Deleting the 'dgwt-wcas-open' class after hiding the suggestion
* FIX: Allows to display HTML entities in suggestions title and description
* FIX: Better synchronizing suggestions and resutls on a search page
* CHANGE: Move menu item to WooCommerce submenu

= 1.1.3, July 12, 2017 =
* ADD: New WordPress filters
* FIX: Repetitive search results
* FIX: Extra details when there are no results

= 1.1.2, June 7, 2017 =
* FIX: Replace deprecated methods and functions in WC 3.0.x

= 1.1.1, June 6, 2017 =
* ADD: Added Portable Object Template file
* ADD: Added partial polish translation
* FIX: WooCommerce 3.0.x compatible
* FIX: Menu items repeated in a search page
* FIX: Other minor bugs

= 1.1.0, October 5, 2016 =
* NEW: Add WPML compatibility
* FIX: Repeating search results for products in a admin dashboard
* FIX: Overwrite default input element rounding for Safari browser

= 1.0.3.1, July 24, 2016 =
* FIX: Disappearing widgets
* FIX: Trivial things in CSS

= 1.0.3, July 22, 2016 =
* FIX: Synchronization WP Query on a search page and ajax search query
* CHANGE: Disable auto select the first suggestion
* CHANGE: Change textdomain to ajax-search-for-woocommerce

= 1.0.2, June 30, 2016 =
* FIX: PHP syntax error with PHP version < 5.3

= 1.0.1, June 30, 2016 =
* FIX: Excess AJAX requests in a detail mode
* FIX: Optimization JS mouseover event in a detail mode
* FIX: Trivial things in CSS

= 1.0.0, June 24, 2016 =
* ADD: [Option] Exclude out of stock products from suggestions
* ADD: [Option] Overwrite a suggestion container width
* ADD: [Option] Show/hide SKU in suggestions
* ADD: Add no results note
* FIX: Search in products SKU
* FIX: Trivial things in CSS and JS files

= 0.9.1, June 5, 2016 =
* ADD: Javascript and CSS dynamic compression
* FIX: Incorrect dimensions of the custom preloader

= 0.9.0, May 17, 2016 =
* ADD: First public release