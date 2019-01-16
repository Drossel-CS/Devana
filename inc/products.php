<?php
add_action( 'init', 'product_register' );
function product_register() {
  $labels = array(
    'name' => _x('Produkty', 'post type general name'),
    'singular_name' => _x('Produkt', 'post type singular name'),
    'add_new' => _x('Pridať nový', 'Produkt'),
    'add_new_item' => __('Pridať nový produkt'),
    'edit_item' => __('Upraviť produkt'),
    'new_item' => __('Nový produkt'),
    'all_items' => __('Všetky produkty'),
    'view_item' => __('Zobraziť produkt'),
    'search_items' => __('Hľadať produkt'),
    'not_found' =>  __('Produkty nenájdené'),
    'not_found_in_trash' => __('No products found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Produkty'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'menu_icon' => 'dashicons-cart',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array( 'title', 'thumbnail', 'revisions', ),
    'register_meta_box_cb' => 'wpt_add_event_metaboxes',
  ); 
  register_post_type('products',$args);
}



//-------------------------------------
function my_taxonomies_products() {
  $labels = array(
'name'              => _x( 'Kategórie produktov', 'taxonomy general name' ),
'singular_name'     => _x( 'Kategória produktov', 'taxonomy singular name' ),
'search_items'      => __( 'Hľadať kategóriu' ),
'all_items'         => __( 'Všetky kategórie produktov' ),
// 'parent_item'       => __( 'Parent SANHA Menu Category' ),
'parent_item_colon' => __( '' ),
'edit_item'         => __( 'Upraviť kategóriu' ), 
'update_item'       => __( 'Aktualizovať kategóriu' ),
'add_new_item'      => __( 'Pridať novú kategóriu' ),
'new_item_name'     => __( 'Nová kategória' ),
'menu_name'         => __( 'Kategórie produktov' ),
);
$args = array(
 'labels' => $labels,
 'hierarchical' => true,
);
register_taxonomy( 'product_category', 'products', $args );
}
add_action( 'init', 'my_taxonomies_products', 0 );
//-------------------------------------


/**
 * Adds a metabox to the right side of the screen under the “Publish” box
 */
function wpt_add_event_metaboxes() {
	add_meta_box(
		'wpt_events_location',
		'Vlastnosti produktu',
		'wpt_events_location',
		'products',
		'side',
		'default'
	);
}

/**
 * Output the HTML for the metabox.
 */
function wpt_events_location() {
	global $post;

	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'event_fields' );

	// Get the location data if it's already been entered
    $description = get_post_meta( $post->ID, 'description', true );
    $price = get_post_meta( $post->ID, 'price', true );
    $size = get_post_meta( $post->ID, 'size', true );
    $availability = get_post_meta( $post->ID, 'availability', true );
    if($availability == '') $availability = 'yes';

    // Output the field
    echo '<label for="description">Popis:</label>';
    echo '<input type="text" name="description" value="' . esc_textarea( $description )  . '" class="widefat">';
    echo '<label for="price">Cena:</label>';
    echo '<input type="text" name="price" value="' . esc_textarea( $price )  . '" class="widefat">';
    echo '<label for="size">Veľkosť:</label>';
    echo '<input type="text" name="size" value="' . esc_textarea( $size )  . '" class="widefat">';

    //Dostupnost
    echo '<label for="availability">Dostupnosť:</label><select name="availability" class="widefat">';
    echo '<option '.(($availability=='yes')?'selected="selected"':"").' value="yes">Ano</option>';
    echo '<option '.(($availability=='no')?'selected="selected"':"").' value="no">Nie</option>';
    echo '</select>'; 
}

/**
 * Save the metabox data
 */
function wpt_save_events_meta( $post_id, $post ) {

	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['size'] ) ||! isset( $_POST['availability'] ) || ! isset( $_POST['price'] ) || ! isset( $_POST['description'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
    $events_meta['description'] = esc_textarea( $_POST['description'] );
    $events_meta['price'] = esc_textarea( $_POST['price'] );
    $events_meta['availability'] = esc_textarea( $_POST['availability'] );
    $events_meta['size'] = esc_textarea( $_POST['size'] );

	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $events_meta as $key => $value ) :

		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}
add_action( 'save_post', 'wpt_save_events_meta', 1, 2 );