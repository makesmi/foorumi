<?php


class KetjuOhjain extends BaseController{
    public static function ketjunLuonti($alueid){
        self::check_logged_in();
        
        $alue = Aihealue::haeTunnuksella($alueid);
        $alueLinkki = self::linkki_alueeseen($alue->id);
        
        self::render_view('uusiketju.html', 
                array('aluelinkki' => $alueLinkki, 'aihealue' => $alue));
        
    }
    
    public static function naytaKetju($ketjuid){
        
        $ketju = Viestiketju::haeTunnuksella($ketjuid);
        $alue = Aihealue::haeTunnuksella($ketju->alue);
        $viestit = Viesti::haeViestit($ketjuid);
        $paivamaarat = array();
        $ajat = array();
        
        foreach($viestit as $avain => $viesti){
            $paivamaarat[$viesti->id] = $viesti->aika;
            $ajat[$viesti->id] = $viesti->aika;
        }
        
        self::render_view('viestiketju.html', 
                array('viestiketju' => $ketju, 'viestit' => $viestit, 
                    'aluenimi' => $alue->nimi, 
                    'aluelinkki' => self::linkki_alueeseen($ketju->alue),
                    'pvm' => $paivamaarat, 'aika' => $ajat));
    }
    
    public static function luoKetju($alueid){
        $parametrit = $_POST;
        $alue = Aihealue::haeTunnuksella($alueid);
        $otsikko = $parametrit['otsikko'];
        $viestiSisalto = $parametrit['viesti'];
        $kirjoittaja = $parametrit['kirjoittaja'];
        
        $ketjuid = Viestiketju::lisaaKetju($alue->id, $otsikko);
        
        Viesti::lisaaViesti($ketjuid, $kirjoittaja, $viestiSisalto);
        
        self::redirect_to('');
    }
    
    private static function linkki_alueeseen($alueid){
        return self::base_path() . '/aihealue/' . $alueid;
    }
}