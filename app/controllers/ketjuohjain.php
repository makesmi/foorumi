<?php

require 'app/models/ketju.php';

class KetjuOhjain extends BaseController{
    public static function ketjunLuonti($alueid){
        $alue = Aihealue::haeTunnuksella($alueid);
        
        self::render_view('uusiketju.html', 
                array('aluelinkki' => self::linkki_alueeseen($alue->id), 
                    'aihealue' => $alue));
        
    }
    
    public static function naytaKetju($id){
        
        $ketju = Viestiketju::haeTunnuksella($id);
        
        self::render_view('viestiketju.html', 
                array('viestit' => $viestit, 'aluenimi' => $alue->nimi, 
                    'aluelinkki' => self::linkki_alueeseen($ketju->alue)));
    }
    
    public static function luoKetju($alueid){
        $parametrit = $_POST;
        $alue = AlueOhjain::haeTunnuksella($alueid);
        $otsikko = $parametrit['otsikko'];
        
        ViestiKetju::lisaaKetju($alue, $otsikko);
        
        
        self::redirect_to('');
    }
    
    private static function linkki_alueeseen($alueid){
        return self::base_path() . '/aihealue/' . $alueid;
    }
}