<?php
namespace ToolboxACFEForms\Integration;

class ACFExtended {

    public function __construct() {

        add_action( 'init' , __CLASS__ . '::init' );        
    }
    
    public static function init() {

        global $acfe;

        if ( !isset( $acfe )) return;

        if ( version_compare( $acfe->version , '0.9' , '>=' ) ) {
            // acfe version >= 0.9
            add_filter( 'acfe/form/load_form' , __CLASS__ . '::modify_render_template' , 10 );
        } else {
            // acfe version < 0.9
            add_filter( 'acfe/form/load' , __CLASS__ . '::try_custom_html' , 10 , 2 );
        }
        
    }
    
    /**
     * try_custom_html
     * 
     * Use Timber Template to render the acfe form
     *
     * @param  mixed $form
     * @param  mixed $post_id
     * @return void
     */
    public static function try_custom_html( $args , $post_id ) {

        global $acfe;

        if ( version_compare( $acfe->version , '0.9' , '>=' ) ) return $args;

        if ( !class_exists( 'Timber' ) ) return $args;

        if ( !has_filter( "toolbox-acfe-forms/{$args['name']}" ) ) return $args;

        $twig_template = apply_filters( "toolbox-acfe-forms/{$args['name']}" , '' );
        $twig_template_success = apply_filters( "toolbox-acfe-forms/success/{$args['name']}" , '' );

        $content = '';
        
        $context = self::timber_context();
        $context[ 'post' ] = new \Timber\Post();
        $context[ 'post_id' ] = 'cool';
        $context[ 'form_args' ] = $args;

        $context = apply_filters( "toolbox-acfe-forms/context" , $context , $post_id );
        $context = apply_filters( "toolbox-acfe-forms/context/{$args['name']}" , $context , $post_id );

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

    /**
     * modify_render_template
     * 
     * Use Timber Template to render the acfe form
     *
     * @param  mixed $form
     * @return void
     */
    public static function modify_render_template( $form ) {

        global $acfe;

        if ( version_compare( $acfe->version , '0.9' , '<' ) ) return $form;
        
        if ( !class_exists( 'Timber' ) ) return $form;
        
        if ( !has_filter( "toolbox-acfe-forms/{$form['name']}" ) ) return $form;
        
        $twig_template = apply_filters( "toolbox-acfe-forms/{$form['name']}" , '' );
        $twig_template_success = apply_filters( "toolbox-acfe-forms/success/{$form['name']}" , '' );
        
        $content = '';
        
        $context = self::timber_context();
        $context[ 'post_id' ] = 'cool';
        $context[ 'form_args' ] = $form;
        
        $context = apply_filters( "toolbox-acfe-forms/context" , $context );
        $context = apply_filters( "toolbox-acfe-forms/context/{$form['name']}" , $context );
        
        // update the render template
        $content = \ToolboxACFEForms\Integration\Timber::render_ignore( $twig_template , $context );
        if ( $content ) $form[ 'render' ] = $content; 
            
        // update the success message
        $content = \ToolboxACFEForms\Integration\Timber::render_ignore( $twig_template_success , $context );
        if ( $content ) $form[ 'success' ][ 'message' ] = $content;
        
        return $form;

    } 
    
    /**
     * timber_context
     * 
     * return v1.x or v2.x context
     *
     * @return void
     */
    private static function timber_context() {
        if (version_compare( \Timber::$version, '2.0.0', '>=' )) {
            // notice we use root Timber here
            $context = \Timber::context();
        } else {
            // notice we use root Timber here
            $context = \Timber::get_context();
            $context[ 'post' ] = new \Timber\Post();

        }

        return $context;
    }
}

