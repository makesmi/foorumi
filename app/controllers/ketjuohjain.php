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
        if($ketju == null){
            self::redirect_to('/etusivu', 
                    array('virheviesti' => 'viestiketjua ei löytynyt!'));
            return;
        }
        
        $alue = Aihealue::haeTunnuksella($ketju->alue);
        $viestit = Viesti::haeViestit($ketjuid);
        $paivamaarat = array();
        $ajat = array();
        $muokkausaika = array();
        $muokkauspvm = array();
        $muokattu = array();
        $kayttaja = self::get_user_logged_in();
        
        foreach($viestit as $avain => $viesti){
            $paivamaarat[$viesti->id] = self::haePvm($viesti->aika);
            $ajat[$viesti->id] = self::haeAika($viesti->aika);
            $muokattu[$viesti->id] = ($viesti->muokkausaika != null);
            if($muokattu[$viesti->id]){
                $muokkausaika[$viesti->id] = self::haeAika($viesti->muokkausaika);
                $muokkauspvm[$viesti->id] = self::haePvm($viesti->muokkausaika);
            }
        }
        
        if($kayttaja != null){
            ViimeinenLuettu::asetaLuetuksi($kayttaja->tunnus, $ketjuid);
        }
        
        self::render_view('viestiketju.html', 
                array('viestiketju' => $ketju, 'viestit' => $viestit, 
                    'aluenimi' => $alue->nimi, 
                    'aluelinkki' => self::linkki_alueeseen($ketju->alue),
                    'pvm' => $paivamaarat, 'aika' => $ajat, 'muokattu' => $muokattu,
                    'muokkauspvm' => $muokkauspvm, 'muokkausaika' => $muokkausaika));
    }
    
    public static function luoKetju($alueid){
        self::check_logged_in();
        
        $parametrit = $_POST;
        $alue = Aihealue::haeTunnuksella($alueid);
        $otsikko = $parametrit['otsikko'];
        $viestiSisalto = $parametrit['viesti'];
        $kirjoittaja = $parametrit['kirjoittaja'];
        
        $ketjuid = Viestiketju::lisaaKetju($alue->id, $otsikko);
        
        Viesti::lisaaViesti($ketjuid, $kirjoittaja, $viestiSisalto);
        
        self::redirect_to('/viestiketju/' . $ketjuid);
    }
    
    private static function linkki_alueeseen($alueid){
        return self::base_path() . '/aihealue/' . $alueid;
    }
}

