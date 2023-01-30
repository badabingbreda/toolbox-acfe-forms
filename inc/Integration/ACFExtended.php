<?php
namespace ToolboxACFEForms\Integration;

class ACFExtended {

    public function __construct() {

        add_filter( 'acfe/form/load' , __CLASS__ . '::try_custom_html' , 10 , 2 );
        
    }
    
    /**
     * try_custom_html
     * 
     * Use Timber Template to render the acfe form
     *
     * @param  mixed $args
     * @param  mixed $post_id
     * @return void
     */
    public static function try_custom_html( $args , $post_id ) {

        if ( !class_exists( 'Timber' ) ) return $args;

        if ( !has_filter( "toolbox-acfe-forms/${args['name']}" ) ) return $args;

        $twig_template = apply_filters( "toolbox-acfe-forms/${args['name']}" , '' );
        $twig_template_success = apply_filters( "toolbox-acfe-forms/success/${args['name']}" , '' );

        $content = '';
        
        $context = \Timber::get_context();
        $context[ 'post' ] = new \Timber\Post();
        $context[ 'post_id' ] = 'cool';
        $context[ 'form_args' ] = $args;

        $context = apply_filters( "toolbox-acfe-forms/context" , $context , $post_id );
        $context = apply_filters( "toolbox-acfe-forms/context/${args['name']}" , $context , $post_id );

        if ( 
            $args[ 'custom_html_enabled' ]
        ) {

            $content = \ToolboxACFEForms\Integration\Timber::render_ignore( $twig_template , $context );
            if ( $content ) $args[ 'custom_html' ] = $content; 
           
        }

        $content = \ToolboxACFEForms\Integration\Timber::render_ignore( $twig_template_success , $context );
        if ( $content ) $args[ 'html_updated_message' ] = $content;

        return $args;

    }

}