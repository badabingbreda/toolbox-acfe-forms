<?php
namespace ToolboxACFEForms\Integration;

class Timber {

    public static function render( $name ) {

        ob_start();
        // notice we use root Timber here
        $data = \Timber::get_context();

        // try to generate without errors
        try {
            \Timber::render( $name , $data );
        } catch( Exception $e ) {
            if ( apply_filters( 'toolbox/twig_error_debug' , true ) ) echo '[ error handling twig template ] ' . $e->getMessage();
        }
        //echo $result;
        wp_reset_postdata();

        return ob_get_clean();

    }

    public static function render_ignore( $name , $context ) {

        ob_start();
        // notice we use root Timber here
        //$data = \Timber::get_context();

        // try to generate without errors
        try {
            \Timber::render_string( "{% include '${name}' ignore missing %}" , $context );
        } catch( Exception $e ) {
            if ( apply_filters( 'toolbox/twig_error_debug' , true ) ) echo '[ error handling twig template ] ' . $e->getMessage();
        }
        //echo $result;
        wp_reset_postdata();

        return ob_get_clean();

    }
   
}