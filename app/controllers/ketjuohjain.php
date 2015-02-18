<?php

require 'app/models/ketju.php';

class KetjuOhjain extends BaseController{
    public static function ketjunLuonti(){
        self::render_view('uusiketju.html');
        
    }
    
    public static function luoKetju(){
        $parametrit = $_POST;
        $alue = $parametrit['alue'];
        $otsikko = $parametrit['otsikko'];
        
        ViestiKetju::lisaaKetju($alue, $otsikko);
        
        self::redirect_to('');
    }
}