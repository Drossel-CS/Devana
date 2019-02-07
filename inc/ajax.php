<?php
/**
 * AJAX Functions
 *
 * 
 *
 * @package drossel_devana
 * 
 * odosielanie emailu z kontaktneho formularu
 */

add_action( 'wp_ajax_nopriv_drossel_save_user_contact_form', 'drossel_save_contact' );
add_action( 'wp_ajax_drossel_save_user_contact_form', 'drossel_save_contact' );

function drossel_save_contact(){
	$title   =  wp_strip_all_tags($_POST["name"]);
	$email   =  wp_strip_all_tags($_POST["email"]);
    $message =  wp_strip_all_tags($_POST["message"]);
    $phone   =  wp_strip_all_tags($_POST["phoneNumber"]);
   
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
   
    ob_start();
	include 'templates/contact-message-html.php';
	$body = ob_get_clean();
   
   
    //email settings
    $to = get_bloginfo('admin_email');
    $subject = 'Salón Lili kontaktný formulár - '.$title;
    
    //$headers[] = 'From: '.get_bloginfo('name').' <'.$to.'>'; 
    $headers[] = 'From: Salón Lili <info@salonlili.sk>';
    $headers[] = 'Reply-To: '.$title.' <'.$email.'>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
   
    //echo wp_mail($to, $subject, $body, $headers);
    echo wp_mail($to, $subject, $body, $headers);

	die();
}
