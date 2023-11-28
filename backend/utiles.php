<?php
    function entero2buleano( $dato ) {
        if ( $dato == 0 ) {
            return false;
        } else {
            return true;
        }
    }
    function generarCodigo($length) {
        $chars = "123456789";
        $clen   = strlen( $chars )-1;
        $id  = '';
        for ($i = 0; $i < $length; $i++) {
        $id .= $chars[mt_rand(0,$clen)];
        }
        return ($id);
    }
?>