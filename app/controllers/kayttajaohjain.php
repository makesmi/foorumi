<?php

require 'app/models/kayttaja.php';

class KayttajaOhjain extends BaseController{
    public static function kayttajaLista(){
        $kayttajat = Kayttaja::haeKaikki();
        self::render_view('kayttajat.html', array('kayttajat' => $kayttajat));
    }
}