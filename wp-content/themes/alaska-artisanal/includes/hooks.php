<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's Action Hooks
 *
 *
 * @file           hooks.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/includes/hooks.php
 * @link           http://codex.wordpress.org/Plugin_API/Hooks
 * @since          available since Release 1.1
 */


/**
 * Just after opening <body> tag
 *
 * @see header.php
 */
function responsive_container() {
    do_action('responsive_container');
}

/**
 * Just after closing </div><!-- end of #container -->
 *
 * @see footer.php
 */
function responsive_container_end() {
    do_action('responsive_container_end');
	tha_footer_before();
}

/**
 * Just after opening <div id="container">
 *
 * @see header.php
 */
function responsive_header() {
    do_action('responsive_header');
	tha_header_before();
}

/**
 * Just after opening <div id="header">
 *
 * @see header.php
 */
function responsive_header_top() {
    do_action('responsive_header_top');
	tha_header_top();
}

/**
 * Just after opening <div id="header">
 *
 * @see header.php
 */
function responsive_in_header() {
    do_action('responsive_in_header');
}

/**
 * Just after closing </div><!-- end of #header -->
 *
 * @see header.php
 */
function responsive_header_bottom() {
    do_action('responsive_header_bottom');
	tha_header_bottom();
}

/**
 * Just after closing </div><!-- end of #header -->
 *
 * @see header.php
 */
function responsive_header_end() {
    do_action('responsive_header_end');
	tha_header_after();
}

/**
 * Just before opening <div id="wrapper">
 *
 * @see header.php
 */
function responsive_wrapper() {
    do_action('responsive_wrapper');
	tha_content_before();
}

/**
 * Just after opening <div id="wrapper">
 *
 * @see header.php
 */
function responsive_wrapper_top() {
    do_action('responsive_wrapper_top');
	tha_content_top();
}

/**
 * Just after opening <div id="wrapper">
 *
 * @see header.php
 */
function responsive_in_wrapper() {
    do_action('responsive_in_wrapper');
}

/**
 * Just before closing </div><!-- end of #wrapper -->
 *
 * @see header.php
 */
function responsive_wrapper_bottom() {
    do_action('responsive_wrapper_bottom');
	tha_content_bottom();
}

/**
 * Just after closing </div><!-- end of #wrapper -->
 *
 * @see header.php
 */
function responsive_wrapper_end() {
    do_action('responsive_wrapper_end');
	tha_content_after();
}

/** Just before <div id="post">
 * 
 * @see index.php
 */
function responsive_entry_before() {
	do_action('responsive_entry_before');
	tha_entry_before();
}

/** Just after <div id="post">
 * 
 * @see index.php
 */
function responsive_entry_top() {
	do_action('responsive_entry_top');
	tha_entry_top();
}

/** Just before </div> <!-- end of div#post -->
 * 
 * @see index.php
 */
function responsive_entry_bottom() {
	do_action('responsive_entry_bottom');
	tha_entry_bottom();
}


/** Just after </div> <!-- end of div#post -->
 * 
 * @see index.php
 */
function responsive_entry_after() {
	do_action('responsive_entry_after');
	tha_entry_after();
}

/** Just before comments_template()
 * 
 * @see index.php
 */
function responsive_comments_before() {
	do_action('responsive_comments_before');
	tha_comments_before();
}

/** Just after comments_template()
 * 
 * @see index.php
 */
function responsive_comments_after() {
	do_action('responsive_comments_after');
	tha_comments_after();
}

/**
 * Just before opening <div id="widgets">
 *
 * @see sidebar.php
 */
function responsive_widgets_before() {
    do_action('responsive_widgets_before');
	tha_sidebars_before();
}

/**
 * Just after opening <div id="widgets">
 *
 * @see sidebar.php
 */
function responsive_widgets() {
    do_action('responsive_widgets');
	tha_sidebar_top();
}

/**
 * Just before closing </div><!-- end of #widgets -->
 *
 * @see sidebar.php
 */
function responsive_widgets_end() {
    do_action('responsive_widgets_end');
	tha_sidebar_bottom();
}

/**
 * Just after closing </div><!-- end of #widgets -->
 *
 * @see sidebar.php
 */
function responsive_widgets_after() {
    do_action('responsive_widgets_after');
	tha_sidebars_after();
}

/**
 * Just after opening <div id="footer">
 *
 * @see footer.php
 */
function responsive_footer_top() {
    do_action('responsive_footer_top');
	tha_footer_top();
}

/**
 * Just before closing </div><!-- end of #footer -->
 *
 * @see footer.php
 */
function responsive_footer_bottom() {
    do_action('responsive_footer_bottom');
	tha_footer_bottom();
}

/**
 * Just after closing </div><!-- end of #footer -->
 *
 * @see footer.php
 */
function responsive_footer_after() {
    do_action('responsive_footer_after');
	tha_footer_after();
}

/**
 * Theme Options
 *
 * @see theme-options.php
 */
function responsive_theme_options() {
    do_action('responsive_theme_options');
}

/**
 * WooCommerce
 *
 * Unhook/Hook the WooCommerce Wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'responsive_woocommerce_wrapper', 10);
add_action('woocommerce_after_main_content', 'responsive_woocommerce_wrapper_end', 10);

function responsive_woocommerce_wrapper() {
    echo '<div id="content-woocommerce" class="grid col-620">';
}

function responsive_woocommerce_wrapper_end() {
    echo '</div><!-- end of #content-woocommerce -->';
}


add_filter( 'woocommerce_checkout_fields' , 'single_address_override_checkout_fields' );

function single_address_override_checkout_fields ( $fields ) {
    unset($fields['order']['order_comments']);
    unset($fields['shipping']['shipping_notes']);
    return $fields;
}
//add_action('woocommerce_thankyou', 'wc_show_split_orders');
add_action('wp_loaded','wc_setup_tradegecko');
function wc_show_split_orders($order_id) { 
    $split_orders = get_post_meta($order_id,'_wc_split_order_ids',true);
    foreach ($split_orders as $split_order_id) { 
        $order = wc_get_order($split_order_id);
        ?>
<ul class="order_details">
			<li class="order">
				<?php _e( 'Order Number:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment Method:', 'woocommerce' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
<?php
    }
}

function aa_get_product_id( \WC_Product $product ) {
		if ( $product instanceof WC_Product_Variation ) {
			$product_id = $product->get_variation_id();
		} else {
			$product_id = $product->id;
		}

		return $product_id;
	}



function wc_setup_tradegecko() { 
    //remove_action( 'wc_tradegecko_export_new_orders', array( $GLOBALS['wc_tg_sync'], 'process_new_order_export' ), 10 );
  //  remove_action( 'woocommerce_payment_complete', array( $GLOBALS['wc_tg_sync'], 'process_order_update' ), 10 );
//    remove_action( 'woocommerce_order_status_on-hold_to_processing', array( $GLOBALS['wc_tg_sync'], 'process_order_update' ) );
 //   remove_action( 'woocommerce_order_status_on-hold_to_completed',  array( $GLOBALS['wc_tg_sync'], 'process_order_update' ) );
  //  remove_action( 'woocommerce_order_status_failed_to_processing', array( $GLOBALS['wc_tg_sync'], 'process_order_update' ) );
   // remove_action( 'woocommerce_order_status_failed_to_completed',  array( $GLOBALS['wc_tg_sync'], 'process_order_update' ) );
    add_action( 'woocommerce_thankyou','process_new_order_split' , 500 );
//    add_action(  'wc_tradegecko_export_new_orders','update_new_order', 1);
    add_filter('wc_tradegecko_new_order_query','modify_exported_order',2,2);
}
 function get_line_items_for_export( $order_id ) {
		// Get order object
     $line_items = array();
		$order = WC_Compat_TG::wc_get_order( (int) $order_id );

        // Add the line items to the query
		$items = $order->get_items();
		foreach ( $items as $item ) {

			$_product = $order->get_product_from_item( $item );
			$prod_id = aa_get_product_id( $_product );
			$is_taxable = 0 < $item['line_tax'] ? true : false;
			$item_tax_rate = 0;

             if ( !$_product->needs_shipping() )
                    continue;
                if ( isset($item['bundled_by']) && !empty($item['bundled_by']) )
                    continue;
                if ( isset($item['composite_parent']) && !empty($item['composite_parent']) )
                    continue;
            
			// If we have tax for the item
			// Calculate a single percentage rate
			if ( $is_taxable ) {
				$item_total_with_tax = $item['line_total'] + $item['line_tax'];
				$item_total_without_tax = $item['line_total'];

				$item_tax_rate = $GLOBALS['wc_tg_sync']->get_tax_rate( $item_total_with_tax, $item_total_without_tax );
			}

			// Cost of the item before discount
			if ( $order->prices_include_tax ) {
				$CostPerUnit = number_format( ( $item['line_subtotal'] + $item['line_subtotal_tax'] ) / $item['qty'], 2, '.', '');
			} else {
				$CostPerUnit = number_format( $item['line_subtotal'] / $item['qty'], 2, '.', '');
			}

			// Get the variant ID from the exported and synced items
			$variant_id = WC_TradeGecko_Init::get_post_meta( $prod_id, 'variant_id', true );

			if ( '' == $variant_id ) {

				// Search for the variant in TG by SKU.
				$variant_data = WC_TradeGecko_Init::get_decoded_response_body( WC_TradeGecko_Init::$api->process_api_request( 'GET', 'variants', null, null, array( 'sku' => $_product->get_sku() ) ) );

				if ( isset( $variant_data->error ) ) {
					// Fail order export, we do not have variant id and could not retrieve one
					throw new Exception( sprintf( __( 'Order export failed for order with order number #%s and ID: %s.'
						. ' Cannot export orders with products, which do not exist in TradeGecko.'
						. ' Product with ID: %s and SKU: %s, does not exist in TradeGecko.', WC_TradeGecko_Init::$text_domain ),
						$order_number,
						$order->id,
						$prod_id,
						$_product->get_sku() ) );
				}

				$variants = isset( $variant_data->variants ) ? $variant_data->variants : $variant_data->variant;
				if ( 0 < count( $variants ) ) {

					foreach( $variants as $variant ) {
						// Make sure the SKU matches
						if ( $_product->get_sku() == $variant->sku ) {
							// Add the first variant we found
							$variant_id = $variant->id;

							// Add the variant ID to the product for future use.
							WC_TradeGecko_Init::update_post_meta( $prod_id, 'variant_id', $variant->id );
							break;
						}
					}

				} else {
					// Fail order export if product is not synced with TG
					throw new Exception( sprintf( __( 'Order export failed for order with order number #%s and ID: %s.'
						. ' Cannot export orders with products, which do not exist in TradeGecko.'
						. ' Product with ID: %s and SKU: %s, does not exist in TradeGecko.', WC_TradeGecko_Init::$text_domain ),
						$order_number,
						$order->id,
						$prod_id,
						$_product->get_sku() ) );

				}
			}

			$line_items[] = array(
				'quantity'	=> (int) $item['qty'],
				'discount'	=> '',
				'price'		=> $CostPerUnit,
				'tax_rate'	=> $item_tax_rate,
				'variant_id'	=> $variant_id,
			);

		}

		// Add the Shipping as freeform
		if ( 0 < WC_Compat_TG::get_total_shipping( $order ) ) {
			$ship_price = WC_Compat_TG::get_total_shipping( $order );

			$is_taxable = 0 < $order->get_shipping_tax() ? true : false;
			$tax_rate_ship = 0;

			if ( $order->prices_include_tax ) {
				$ship_price += $order->get_shipping_tax();
			}

			if ( $is_taxable ) {
				$shipping_total_with_tax = $order->prices_include_tax ? $ship_price : $ship_price + $order->get_shipping_tax();
				$shipping_total_without_tax = $order->prices_include_tax ? $ship_price - $order->get_shipping_tax() : $ship_price;

				$tax_rate_ship = $GLOBALS['wc_tg_sync']->get_tax_rate( $shipping_total_with_tax, $shipping_total_without_tax );
			}

			$line_items[] = array(
				'quantity'	=> 1,
				'price'		=> number_format( $ship_price, 2, '.', ''),
				'freeform'	=> 'true',
				'tax_rate'	=> $tax_rate_ship,
				'line_type'	=> 'Shipping',
				'label'		=> 'Shipping'
			);
		}

		// Add another item for the discount as freeform
		if ( 0 < $order->get_total_discount() ) {
			$line_items[] = array(
				'quantity'	=> 1,
				'price'		=> '-'.number_format( $order->get_total_discount(), 2, '.', ''),
				'freeform'	=> 'true',
				'line_type'	=> 'Discount',
				'label'		=> 'Discount'
			);
		}
        return $line_items;

	}
function modify_exported_order($order_info, $order_id) { 
    $line_items = array();
    $items = get_line_items_for_export($order_id);

    $order_info['order']['order_line_items'] = $items;
    return $order_info;
}
function process_new_order_split($order_id) { 
    
   $order_ids = wc_split_orders($order_id);
   
   if ($order_ids != false && is_array($order_ids)) {
     $GLOBALS['wc_tg_sync']->process_order_update($order_ids);
 // foreach ($order_ids as $split_id) { 
	
	//	    do_action( 'wc_tradegecko_export_new_orders', $split_id);

     //  }
   }   
}
function wc_prevent_email($recipient, $order) { 
    return false;
}
function wc_split_orders($order_id) { 

$ret = array($order_id);
    $firstorder = true;
    if ($order_id == null)
        return false;
    $packages = get_post_meta( $order_id, '_shipping_packages',true);
   /* if (count($packages) == 1) {
      $order = wc_get_order($order_id);

            
            $order->remove_order_items('line_item');

        foreach ( $packages as $pkg_idx => $pkg ) {
            $update_order_id  = $order_id;
            foreach ($pkg['contents'] as $key=>$product) { 
                if ( !$product['data']->needs_shipping() )
                    continue;
                if ( isset($product['bundled_by']) && !empty($product['bundled_by']) )
                    continue;
                if ( isset($product['composite_parent']) && !empty($product['composite_parent']) )
                    continue;
                $order->add_product($product['data'],$product['quantity'],$product);
            }
            update_post_meta($order->id,'_shipping_methods',array($methods[0]));

            update_post_meta($order->id,'_shipping_packages',array($packages[0]));
            $order->remove_order_items( 'shipping' ) ;

            $m = new WC_Shipping_Rate('free_shipping','Free Shipping', 0.0, array(), 'free_shipping');
            $order->add_shipping($m);                   
            $order->calculate_totals();
        }
        return $order_id;
        
    }*/
    if ($packages == null || !is_array($packages))
        return false;
    $methods =  get_post_meta( $order_id, '_shipping_methods',true   );
    
  //  print_r($methods);echo "<hr />";
    if (get_post_meta($order_id,'_shipping_packages_split', true) == true)
        return false;
    update_post_meta( $order_id, '_shipping_packages_split',true);
    $originalorder = wc_get_order($order_id);
    $split_orders = array();
    $ind = 1;
    foreach ( $packages as $pkg_idx => $pkg ) {

        $update_order_id = $order_id;

        if ($firstorder == false) {
                
            $order = wc_create_order();
            add_filter( 'woocommerce_email_recipient_' . $order->id, 'wc_prevent_email',10,2 );
            $original_meta = get_post_meta($originalorder->id);

            foreach ($original_meta as $metakey=>$value)

            {

                if ($metakey != 'id' && $metakey != 'order_id' && $metakey != 'order_key'&&$metakey !="_wcms_packages"&&$metakey !=WC_TradeGecko_Init::$meta_prefix . "synced_order_id" && $metakey != '_shipping_packages')

                    update_post_meta($order->id,$metakey,$value[0]);
                

            }

            $update_order_id = $order->id;
            array_push($split_orders,$order->id);
            foreach ($pkg['contents'] as $key=>$product)

                $order->add_product($product['data'],$product['quantity'],$product);
            $order->remove_order_items( 'shipping' ) ;
    
            $m = new WC_Shipping_Rate('free_shipping','Free Shipping', 0.0, array(), 'free_shipping');
$order->add_shipping($m);
            
            update_post_meta($order->id,'_shipping_methods',array($methods[$ind]));
            update_post_meta($order->id,'_shipping_packages',array($packages[$ind]));
            update_post_meta($order->id, '_wcms_packages_split',$packages);
            update_post_meta($order->id,'_wcms_packages',null);
            $ind++;
            
            
            //     foreach ($methods as $method)

            //        $order->add_shipping($method);

            $order->calculate_totals();
            $order->update_status( 'cloned');
            $order->update_status( $originalorder->status);

            $order->add_order_note("Split from order " . $originalorder->id);
            array_push($ret,$order->id);

        } else {

            $order = wc_get_order($order_id);

            
            $order->remove_order_items('line_item');

            $update_order_id  = $order_id;
            foreach ($pkg['contents'] as $key=>$product) { 
                if ( !$product['data']->needs_shipping() )
                    continue;
                if ( isset($product['bundled_by']) && !empty($product['bundled_by']) )
                    continue;
                if ( isset($product['composite_parent']) && !empty($product['composite_parent']) )
                    continue;
                $order->add_product($product['data'],$product['quantity'],$product);
            }
            update_post_meta($order->id,'_shipping_methods',array($methods[0]));

            update_post_meta($order->id,'_shipping_packages',array($packages[0]));
            update_post_meta($order->id, '_wcms_packages_split',$packages);
            update_post_meta($order->id,'_wcms_packages',null);
            $order->remove_order_items( 'shipping' ) ;

            $m = new WC_Shipping_Rate('free_shipping','Free Shipping', 0.0, array(), 'free_shipping');
$order->add_shipping($m);                   
            $order->calculate_totals();
        
        }

        $firstorder = false;

        
       
        // Set up shipping address:
        $s_first_name = get_post_meta($update_order_id, '_shipping_first_name',true);
        $s_last_name = get_post_meta($update_order_id,'_shipping_last_name',true);
        foreach (  $pkg['full_address'] as $key=>$value) { 
            if ($value != null && $value != '')
                update_post_meta( $update_order_id, '_shipping_'.$key,  $value );
        }
//        if (count($packages) > 1) { 
  //         update_post_meta( $update_order_id, '_shipping_first_name',  $s_first_name );
    //       update_post_meta( $update_order_id, '_shipping_last_name',  $s_last_name );
            
      //  }
        
        
        
    }
    update_post_meta($order_id,'_wc_split_order_ids',$split_orders);
    
    return $ret;
}

// Action: add_action( 'wc_tradegecko_order_update_synchronization', array( $this, 'wc_tradegecko_automatic_order_update_sync' ) );
//	do_action( 'woocommerce_shipstation_shipnotify', $order, array( 'tracking_number' => $tracking_number, 'carrier' => $carrier, 'ship_date' => $timestamp, 'xml' => $shipstation_xml ) );

add_action('woocommerce_order_status_completed', 'alaska_export_order_status_to_tradegecko');
function alaska_export_order_status_to_tradegecko($order_id) { 
       //// Now that we filtered all open orders, sync the information with TG
//		$tg_open_orders = WC_TradeGecko_Init::get_decoded_response_body( WC_TradeGecko_Init::$api->process_api_request( 'GET', 'orders', null, null, array( 'ids' => $tg_order_ids ) ) );

	/**
	 * Build an API request
	 *
	 * @access public
	 * @since 1.0
	 * @param string $method Method of request GET, POST, PUT, DELETE.
	 * @param string $request_type The type of request performed exp: orders, products, order_line_items
	 * @param mixed $request_body The request body. Can be associative array or a json string.
	 * @param int|optional $specific_id The ID of a specific item we want to request.
	 * @param array|optional $filters Parameters to filter the request by. Exp: ids, company_id, order_id, purchase_order_id, since etc.
	 * @return string The json encoded string of the response.
	 */
//	public function process_api_request( $method, $request_type, $request_body = null, $specific_id = null, $filters = array() ) {
     if ( $tg_id = WC_TradeGecko_Init::get_post_meta( $order_id, 'synced_order_id', true ) ) {
         $tg_order = WC_TradeGecko_Init::$api->process_api_request('GET','orders','',$tg_id);
         //"fulfillment_status":"unshipped"
         $tg_order_details = json_decode($tg_order['body']);
         if ( $tg_order_details->order->fulfillment_status == "unshipped") { 
            // Mark it as shipped
            $response = WC_TradeGecko_Init::$api->process_api_request('PUT','orders',array('status'=>'fulfilled'),$tg_id);
         }
     }
}