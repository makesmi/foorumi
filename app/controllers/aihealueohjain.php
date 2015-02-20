<?php



class AlueOhjain extends BaseController{
    
    public function etusivu($tila = null){
        
        $alueet = Aihealue::haeAlueet();
        $linkit = array();
        $viesteja = array();
        $ketjuja = array();
        $lukemattomia = array();
        $kayttaja = self::get_user_logged_in();
        
        foreach($alueet as $avain => $alue){
            $linkit[$alue->id] = 'aihealue/' . $alue->id;
            $ketjuja[$alue->id] = $alue->ketjuja();
            $viesteja[$alue->id] = $alue->viesteja();
            if($kayttaja != null){
                $lukemattomia[$alue->id] = ViimeinenLuettu::
                        lukemattomiaAlueessa($kayttaja->tunnus, $alue);
            }else{
                $lukemattomia[$alue->id] = 0;
            }
        }
        
        self::render_view('etusivu.html', 
                array('aihealueet' => $alueet, 'linkki' => $linkit,
                    'viesteja' => $viesteja, 'ketjuja' => $ketjuja,
                    'lukemattomia' => $lukemattomia));
    }
    
    public static function naytaAlue($id){
        $alue = Aihealue::haeTunnuksella($id);
        
        if($alue == null){
            self::redirect_to('/etusivu', 
                    array('virheviesti' => 'aihealuetta ei löytynyt!'));
        }else{
            $aloittajat = array();
            $viesteja = array();
            $lukematta = array();
            $viestiketjut = Viestiketju::haeKetjut($alue);
            $kayttaja = self::get_user_logged_in();

            foreach($viestiketjut as $avain => $ketju){
                $aloittajat[$ketju->id] = $ketju->aloittajanTunnus();
                $viesteja[$ketju->id] = $ketju->viesteja();
                if($kayttaja != null){
                   $lukematta[$ketju->id] = ViimeinenLuettu::
                           lukemattomiaKetjussa($kayttaja->tunnus, $ketju->id);
                }else{
                   $lukemattu[$ketju->id] = 0;
                }
            }

            self::render_view('aihealue.html', array('aihealue' => $alue, 
                'aloittajat' => $aloittajat, 'viesteja' => $viesteja,
                'viestiketjut' => $viestiketjut, 'lukematta' => $lukematta));
        }
    }
    
    public static function poistaAlue($id){
        Aihealue::poistaAlue($id);
        self::render_view('etusivu.html', 
                array('ilmoitusviesti' => 'aihealue poistettu.'));
    }
    
    public static function uusiAlue(){
        $parametrit = $_POST;
        $otsikko = $parametrit['otsikko'];
        $selitys = $parametrit['selitys'];
        
        Aihealue::lisaaAlue($otsikko, $selitys);
        
        self::redirect_to('/etusivu');
    }
}