<?php
/**
 * Plugin Name: REST test
 * Description: Plugin to work with REST API custom endpoints
 * Author: Miloš Ristić
 * Author URI: /
 */
 
 add_action( 'rest_api_init', 'register_api_hooks' );
function register_api_hooks() {

    register_rest_route( 'moj-rest/v1', '/author/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_users_posts',
        'args' => array(
            'id' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric( $param );
                }
            ),
        )
    ) );
}


// Return all post from author
function get_users_posts($data) {
    $posts = get_posts( array(
        'author' => $data['id'],
    ) );

    if ( empty( $posts ) ) {
        return new WP_Error( 'awesome_no_author', 'Invalid author', array( 'status' => 404 ) );
    }

    $output = '';
    foreach ( $posts as $one_post ) {
        $output .= $one_post->post_title . ' ';
    }

    return $output;
}
