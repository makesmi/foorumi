<?php

  class HelloWorldController extends BaseController{

    public static function index(){
        echo 'Tämä on etusivu!';
    }
    
    public static function etusivu_yllapito(){
        self::render_view('suunnitelmat/etusivu_yllapito.html');
    }

    public static function etusivu(){
        self::render_view('suunnitelmat/etusivu.html');
    }

    public static function aihealue(){
        self::render_view('suunnitelmat/aihealue.html');
    }
    
    public static function viestiketju(){
        self::render_view('suunnitelmat/viestiketju.html');
        
    }
    
    public static function uusiKetju(){
        self::render_view('suunnitelmat/uusiketju.html');
    }
    public static function kayttajat(){
        self::render_view('suunnitelmat/kayttajat.html');
    }
    
    public static function sandbox(){
        self::render_view('helloworld.html');
    }
    
    public static function rekist(){
        self::render_view('suunnitelmat/rekist.html');
    }
    
    public static function muokkaus(){
        self::render_view('suunnitelmat/muokkaus.html');
    }
  }
