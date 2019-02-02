<?php
/**
 * Sliders
 *
 *
 *
 * Pre navysenie poctu obrazkov pridaj polozku do pola $meta_keys
 */

add_action('init', 'slider_register');
function slider_register()
{
    $labels = array(
        'name' => _x('Slidery', 'post type general name'),
        'singular_name' => _x('Slider', 'post type singular name'),
        'add_new' => _x('Pridať nový', 'Slider'),
        'add_new_item' => __('Pridať nový slider'),
        'edit_item' => __('Upraviť slider'),
        'new_item' => __('Nový slider'),
        'all_items' => __('Všetky slidery'),
        'view_item' => __('Zobraziť slider'),
        'search_items' => __('Hľadať slider'),
        'not_found' => __('Slidery nenájdené'),
        'not_found_in_trash' => __('No products found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Slidery',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-images-alt',
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'thumbnail'),
    );
    register_post_type('drossel_sliders', $args);
}

add_filter( 'manage_edit-drossel_sliders_columns', 'drossel_sliders_columns' ) ;

function drossel_sliders_columns( $columns ) {

	$columns = array(
		'cb' => '&lt;input type="checkbox" />',
		'title' => __( 'Slider' ),
		'Shortcode' => __( 'Shortcode' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_drossel_sliders_posts_custom_column', 'manage_drossel_slider_columns', 10, 2 );
function manage_drossel_slider_columns( $column, $post_id ) {
	global $post;
    echo __( '[slider id="'.$post_id.'"]' );
}


add_action('do_meta_boxes', 'remove_thumbnail_box');

function remove_thumbnail_box()
{
    remove_meta_box('postimagediv', 'drossel_sliders', 'side');

}

//inicializacia metaboxu pre obrazky
add_action('init', 'custom_postimage_setup');
function custom_postimage_setup()
{
    add_action('add_meta_boxes', 'custom_postimage_meta_box');
    add_action('save_post', 'custom_postimage_meta_box_save');
}

function custom_postimage_meta_box()
{

    add_meta_box('custom_postimage_meta_box', __('Obrázky pre slider', 'yourdomain'), 'custom_postimage_meta_box_func', 'drossel_sliders', 'normal', 'high');

}

function custom_postimage_meta_box_func($post)
{

    //Do pola pridaj polozky ak je potrebny vacsi pocet obrazkov. Nezabudni toto iste pole dat aj do funcie custom_postimage_meta_box_save
    $meta_keys = array('first_image', 'second_image', 'third_image', 'fourth_image', 'fifth_image');
    $i = 0;

    // $terms = get_terms([
    //     'taxonomy' => 'product_category',
    //     'hide_empty' => false,
    // ]);

    foreach ($meta_keys as $meta_key) {
        //get img
        $image_meta_val = get_post_meta($post->ID, $meta_key, true);

        /**Selectbox logika
        * Selectbox mal sluzit na vyber kategorie produktov a link sa mal automaticky generovat v shortcodes.php na stranku
        * na ktorej by bol shortcode s danou kategoriou produktov pridany 
        * V pripade, ze nie je priradena ziadna kategoria, berie z pola objektov $terms prvy objekt. 
        * V meta selectboxu je ulozene len term_id na zaklade ktoreho je potrebne ziskat cely term objekt.
        * 
        */
        // $slider_category_id = get_post_meta( $post->ID, $meta_key.'_category', true );
        // if($slider_category_id == '') $slider_category_id = $terms[0]->term_id;
        // $slider_category = get_term_by('id', $slider_category_id, 'product_category');

        $image_meta_val_minus_one = '';
        if ($i > 0) {
            $image_meta_val_minus_one = get_post_meta($post->ID, $mtk, true);
        }

        $image_meta_val_plus_one = '';
        if ($i < sizeof($meta_keys)-1) {
            $image_meta_val_plus_one = get_post_meta($post->ID, $meta_keys[$i+1], true);
        }

      
        $post_link = get_post_meta($post->ID, $meta_key.'_link', true);
        if($post_link == '0') $post_link = '';
        ?>
        <div class="custom_postimage_wrapper" id="<?php echo $meta_key; ?>_wrapper" style="<?php echo (($image_meta_val_minus_one != '' || $i == 0) ? 'display:block; margin-bottom:10px;' : 'display:none;'); ?> " >
            <h3 class="img-title" style="<?php echo (($image_meta_val_minus_one != '' || $i == 0) ? 'display:block;' : 'display:none;'); ?> ">Obrázok <?php echo $i + 1; ?></h3>
            <img src="<?php echo ($image_meta_val != '' ? wp_get_attachment_image_src($image_meta_val)[0] : ''); ?>" style="width:15%;display: <?php echo ($image_meta_val != '' ? 'block' : 'none'); ?>" alt="">
            <a class="addimage" style="<?php echo (($image_meta_val_minus_one != '' || $i == 0) ? 'display:block; cursor:pointer;' : 'display:none; pointer-events: none;'); ?> " onclick="custom_postimage_add_image('<?php echo $meta_key; ?>','<?php echo (sizeof($meta_keys) - 1 != $i ? $meta_keys[$i + 1] : 'last') ?>','<?php echo ($i != 0 ? $meta_keys[$i - 1] : 'first') ?>');"><?php _e(($image_meta_val != '' ? 'Zmeniť obrázok ' : 'Pridať obrázok '), 'yourdomain');?></a><br>
            <input name="<?php echo $meta_key; ?>_link" class="link_input" type="text" placeholder="link" style="display: <?php echo ($image_meta_val != '' ? 'block' : 'none');?>" value="<?php echo $post_link ?>">
            
            <!-- <select class="category_select" style="display: <?php //echo ($image_meta_val != '' ? 'block' : 'none'); ?>" name="<?php //echo $meta_key; ?>_category">
                <?php
                // echo '<option value="' . $slider_category->term_id . '">' . $slider_category->name . '</option>';
                // foreach ($terms as $term):
                //     if($slider_category->term_id == $term->term_id) continue;
                //     echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                // endforeach;
                ?>
            </select> -->

            <a class="removeimage" style="color:#a00;cursor:pointer;display: <?php echo ($image_meta_val != '' && $image_meta_val_plus_one == '' ? 'block' : 'none'); ?>" onclick="custom_postimage_remove_image('<?php echo $meta_key; ?>','<?php echo (sizeof($meta_keys) - 1 != $i ? $meta_keys[$i + 1] : 'last') ?>','<?php echo ($i != 0 ? $meta_keys[$i - 1] : 'first') ?>');"><?php _e('Odstrániť obrázok', 'yourdomain');?></a>
            <input type="hidden" name="<?php echo $meta_key; ?>" id="<?php echo $meta_key; ?>" value="<?php echo $image_meta_val; ?>" />
            <hr class="line" style="<?php echo (($image_meta_val_minus_one != '' || $i == 0) ? 'display:block;' : 'display:none;'); ?> " >
        </div>
        <?php
        $mtk = $meta_key;
        $i++;
    }
    ?>

    <script>
    function custom_postimage_add_image(key, next, prev){

        var $wrapper = jQuery('#'+key+'_wrapper');
        var $nextWrapper = jQuery('#'+next+'_wrapper');
        var $prevWrapper = jQuery('#'+prev+'_wrapper');

        custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('select image', 'yourdomain');?>',
            button: {
                text: '<?php _e('select image', 'yourdomain');?>'
            },
            multiple: false
        });

        custom_postimage_uploader.on('select', function() {

            var attachment = custom_postimage_uploader.state().get('selection').first().toJSON();
            var img_url = attachment['url'];
            var img_id = attachment['id'];
            $wrapper.find('input#'+key).val(img_id);
            $wrapper.find('img').attr('src',img_url);
            $wrapper.find('img').show();
            $wrapper.find('.link_input').show();
            $wrapper.find('a.removeimage').show();
            if(prev != 'first'){
                $prevWrapper.find('a.removeimage').css('display','none');
            }
            $wrapper.find('.addimage').text('Zmeniť obrázok');
            if(next != 'last'){
                $nextWrapper.css('display','block');
                $nextWrapper.find('.line').css('display','block');
                $nextWrapper.find('.img-title').css('display','block');
                $nextWrapper.find('.addimage').css({
                                                    'pointer-events': '',
                                                    'cursor': 'pointer',
                                                    'display': 'block'});
            }
        });
        custom_postimage_uploader.on('open', function(){
            var selection = custom_postimage_uploader.state().get('selection');
            var selected = $wrapper.find('input#'+key).val();
            if(selected){
                selection.add(wp.media.attachment(selected));
            }
        });
        custom_postimage_uploader.open();
        return false;
    }

    function custom_postimage_remove_image(key, next, prev){
        var $wrapper = jQuery('#'+key+'_wrapper');
        var $nextWrapper = jQuery('#'+next+'_wrapper');
        var $prevWrapper = jQuery('#'+prev+'_wrapper');
        $wrapper.find('input#'+key).val('');
        $wrapper.find('img').hide();
        $wrapper.find('a.removeimage').hide();
        $wrapper.find('.addimage').text('Pridať obrázok');
        $wrapper.find('.link_input').val('').hide();

        if(next != 'last'){
            $nextWrapper.css('display','none');
            $nextWrapper.find('.addimage').css({
                                                'pointer-events': '',
                                                'cursor': '',
                                                'display': 'none'});
        }
        if(prev != 'first'){
            $prevWrapper.find('a.removeimage').css('display','block');
        }
        return false;
    }

    </script>

    <?php
wp_nonce_field('custom_postimage_meta_box', 'custom_postimage_meta_box_nonce');
}

function custom_postimage_meta_box_save($post_id)
{

    if (!current_user_can('edit_posts', $post_id)) {return 'not permitted';}

    if (isset($_POST['custom_postimage_meta_box_nonce']) && wp_verify_nonce($_POST['custom_postimage_meta_box_nonce'], 'custom_postimage_meta_box')) {

        //To iste pole ako custom_postimage_meta_box_func($post)
        $meta_keys = array('first_image', 'second_image', 'third_image', 'fourth_image', 'fifth_image');
        $i=0;
        foreach ($meta_keys as $meta_key) {
            if (isset($_POST[$meta_key]) && intval($_POST[$meta_key]) != '') {
                update_post_meta($post_id, $meta_key, intval($_POST[$meta_key]));
                update_post_meta($post_id, $meta_key.'_link', $_POST[$meta_key.'_link']);
                $i++;
            } else {
                update_post_meta($post_id, $meta_key, '');
                update_post_meta($post_id, $meta_key.'_link', '');
            }
        }
        update_post_meta($post_id, 'number_of_img', $i);
    }
}