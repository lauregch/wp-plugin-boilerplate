<?php

namespace PluginBoilerplate\Helpers;

use WP_Error;


class Upload {


    static function upload_file( $file ) {

        if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $movefile = wp_handle_upload( $file, array('test_form' => false));

        if( !isset($movefile['error']) && !isset($movefile['upload_error_handler']) ) {
            $filename = $movefile['file'];

            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type' => $movefile['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $filename);

            return $attach_id;
        }
        return new WP_Error();
    }


    static function add_attachment( $urls, $title, $parent_id=false ){

        if ( ! is_array($urls) ) $urls = [ $urls ];

        $code = false;
        $k = 0;

        while ( $k < count($urls) && $code !== 200 ) {
            $code = wp_remote_retrieve_response_code( wp_remote_get( $urls[$k++] ) );
        } 
        
        if ( $code == 200 ) {

            $url = $urls[ $k-1 ];

            $url = str_replace('https', 'http', $url);
            $upload_dir = wp_upload_dir();

            $pathinfo = pathinfo( parse_url($url, PHP_URL_PATH) );
            
            $ext = (isset($pathinfo['extension']) ? $pathinfo['extension'] : '');
            if (strpos($ext,'?') !== false) { 
                $ext = substr( $ext, 0, strpos($ext, '?') );
            }
            // $image_name = microtime(true).'.'.$ext;
            $image_name = md5($url).'.'.$ext;

            if ( wp_mkdir_p($upload_dir['path']) )
                $file = $upload_dir['path'].'/'.$image_name;
            else
                $file = $upload_dir['basedir'].'/'.$image_name;

            $headers = get_headers( $url, 1 );
            if (isset( $headers['Location']) ) {
                $url = $headers['Location']; // string
            } 

            if ( @copy( $url, $file ) ) {

                $wp_filetype = wp_check_filetype( basename($file) );
                $filetype = $wp_filetype['type'];

                $attachment = array(
                    'guid' => $upload_dir['baseurl'].'/'._wp_relative_upload_path( $file ), 
                    'post_mime_type' => $filetype,
                    'post_title' => $title,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_author' => get_current_user_id()
                );
                $attach_id = wp_insert_attachment( $attachment, $file, $parent_id );
                // you must first include the image.php file
                // for the function wp_generate_attachment_metadata() to work
                require_once(ABSPATH.'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                return $attach_id;

            }

        }

        return false;

    }


}