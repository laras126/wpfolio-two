<?php



/////////////////////////
// ATTACHMENT METADATA //
/////////////////////////

// http://net.tutsplus.com/tutorials/wordpress/creating-custom-fields-for-attachments-in-wordpress/
// http://wordpress.stackexchange.com/questions/31211/custom-field-not-updating-when-value-is-empty/31217#31217

// Add custom fields to image uploader.
function wpf_fields_edit( $form_fields, $post ) {

	$post->post_type == 'attachment';

    // Date
    $form_fields[ 'wpf_g_date' ] = array(
        'label' => __( 'Date' ),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, '_wpf_g_date', true ),
        'helps' => __('When did you make it?')
    );

    // Medium
    $form_fields[ 'wpf_g_medium' ] = array(
        'label' => __( 'Medium' ),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, '_wpf_g_medium', true ),
        'helps' => __('e.g. Oil Painting, Monotype, Performance, etc.')
    );

    $form_fields[ 'wpf_g_medium' ][ 'label' ] = __( 'Medium' );
    $form_fields[ 'wpf_g_medium' ][ 'input' ] = 'text';
    $form_fields[ 'wpf_g_medium' ][ 'value' ] = get_post_meta( $post->ID, '_wpf_g_medium', true );

    // Dimensions
    $form_fields[ 'wpf_g_dimen' ] = array(
        'label' => __( 'Dimensions' ),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, '_wpf_g_dimen', true ),
        'helps' => __('e.g. 12" x 14"')
    );
    $form_fields[ 'wpf_g_dimen' ][ 'label' ] = __( 'Dimensions' );
    $form_fields[ 'wpf_g_dimen' ][ 'input' ] = 'text';
    $form_fields[ 'wpf_g_dimen' ][ 'value' ] = get_post_meta( $post->ID, '_wpf_g_dimen', true );

    // Additional Info
    $form_fields[ 'wpf_g_additional' ] = array(
        'label' => __( 'Additional Info' ),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, '_wpf_g_additional', true ),
        'helps' => __('Anything you\'d like to add?')
    );
    $form_fields[ 'wpf_g_additional' ][ 'label' ] = __( 'Additional Info' );
    $form_fields[ 'wpf_g_additional' ][ 'input' ] = 'textarea';
    $form_fields[ 'wpf_g_additional' ][ 'value' ] = get_post_meta( $post->ID, '_wpf_g_additional', true );

    // Collaborators
    $form_fields[ 'wpf_g_collabs' ] = array(
        'label' => __( 'Collaborators/Credits' ),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, '_wpf_g_collabs', true ),
        'helps' => __('e.g. Collaborators: Harry and James, Thanks to SMFA Boston, etc.')
    );
    $form_fields[ 'wpf_g_collabs' ][ 'label' ] = __( 'Collaborators' );
    $form_fields[ 'wpf_g_collabs' ][ 'input' ] = 'text';
    $form_fields[ 'wpf_g_collabs' ][ 'value' ] = get_post_meta( $post->ID, '_wpf_g_collabs', true );

	return $form_fields;
}

//add_filter( 'attachment_fields_to_edit', 'wpf_fields_edit', NULL, 2 );


// Save the custom field values
function wpf_fields_save( $post, $attachment ) {
    $fields = array('wpf_g_medium', 'wpf_g_date', 'wpf_g_dimen', 'wpf_g_additional', 'wpf_g_collabs');
    foreach( $fields as $field ) {
        $key = '_' . $field;
        if( isset( $attachment[ $field ] ) ) {
            if( trim( $attachment[ $field ] ) == '' ) {
                $post[ 'errors' ][ $field ][ 'errors' ][] = __( 'Error! Something went wrong.' );
            }
            update_post_meta( $post[ 'ID' ], $key, $attachment[ $field ] );
        
        }    
    }
    
	return $post;

} 

//add_filter( 'attachment_fields_to_save', 'wpf_fields_save', NULL, 2 );

// Print the values - called in attachment.php
function get_artwork_fields_info() {
	global $post;

    $fields = array('wpf_g_medium', 'wpf_g_date', 'wpf_g_dimen', 'wpf_g_additional', 'wpf_g_collabs');
    $title = $post->post_title;

    $shortname =  get_option('of_shortname');
    $show_info = get_option($shortname . '_show_artwork_info' );

    // If the 'Show info' option is yes and the values exist, print them. 
    if( $show_info == 0 && $fields ) {

        echo '<ul id="artwork-meta" style="margin-left:' . get_margin() . 'px;"><li><em>' . $title . '</em></li>';

        foreach ( $fields as $field ) {

            $key = '_' . $field;
            $meta =  get_post_meta( $post->ID, $key, true );

            if ( $meta ) {
                echo '<li>';
                echo $meta;
                echo '</li>';
            }
       }

       echo '</ul>';
    }

}

function get_margin() {
    
    global $post;
    // Get the image width, calculate the margin to line up list with the image
    $img_meta = wp_get_attachment_metadata( $post->ID );
    $width = $img_meta['width'];

    // Make sure the margin stays within the page
    if ( $width <= 940 ) {
        $margin = 940/2 - $width/2;
    } else {
        $margin = 0;
    }

    return $margin;
}

?>