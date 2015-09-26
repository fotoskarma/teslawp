<?php

class TT_Load extends TeslaFramework{

    function __construct() {

    }

    function helper( $helper ) {
        if ( $this->helper_exists( $helper ) ) {
            require_once TTF . '/helpers/' . $helper . '.php';
        }
        else
            exit( "Helper $helper was not found" );
    }

    function helper_exists( $class ) {
        if ( file_exists( TTF . '/helpers/' . $class . '.php' ) )
            return TRUE;
        else
            return FALSE;
    }

    function view_exists( $name, $config = NULL ) {
        if($config === NULL)
            $result = file_exists( TTF . '/views/' . $name . '.php' );
        else
            $result = file_exists( TT_THEME_DIR.'/theme_config/'.$name.'.php' );
        if ( $result )
            return TRUE;
        else
            return FALSE;
    }

    function view( $_name, $_data = NULL, $__return = FALSE, $config = NULL ) {
        $_name = strtolower( $_name );
        if ( !$this->view_exists( $_name, $config ) )
            exit( 'View not found: ' . $_name );
        if ( $_data !== NULL && count( $_data ) > 0 )
            foreach ( $_data as $_name_var => $_value )
                ${$_name_var} = $_value;
        ob_start();
        if($config === NULL)
            require TTF . '/views/' . $_name . '.php';
        else
            require TT_THEME_DIR.'/theme_config/'.$_name.'.php';
        $buffer = ob_get_clean();
        if ( $__return === TRUE )
            return $buffer;
        else
            echo $buffer;
    }
}