<?php

  $app->get('/', function() {
    HelloWorldController::etusivu();
  });

  $app->get('/hiekkalaatikko', function() {
//      TestiOhjain::hiekkalaatikko();
    KayttajaOhjain2::testi();
  });
  
  $app->get('/etusivu', function() {
      AlueOhjain::etusivu();
  });
  
  $app->get('/etusivu/:tila', function($tila){
      AlueOhjain::etusivu($tila);
  });
  
  $app->get('/etusivu_yllapito', function() {
      HelloWorldController::etusivu_yllapito();
  });

  $app->get('/aihealue', function() {      
      HelloWorldController::aihealue();
  });
  
  $app->get('/viestiketju', function() {      
      HelloWorldController::viestiketju();
  });
  
  $app->get('/uusiketju', function() {
      HelloWorldController::uusiKetju();
  });
  
  $app->get('/kayttajat', function() {
      KayttajaOhjain::kayttajaLista();
  });
  
  $app->get('/rekist/:tila', function($tila) {
      KayttajaOhjain::rekisterointilomake($tila);
  });

  $app->get('/muokkaus', function() {
      HelloWorldController::muokkaus();
  });
  
  $app->get('/virhe', function() {
      HelloWorldController::virhe();
  });
 
 $app->get('/kirjaudu_ulos', function(){
     KayttajaOhjain::kirjaudu_ulos();
});
 
 $app->get('/poista_alue/:id', function($id){
     AlueOhjain::poistaAlue($id);
 });
 
 $app->post('/kirjaudu', function(){
     KayttajaOhjain::kirjaudu();
 });
  
 $app->post('/muuta_kayttajaa/:tunnus', function($tunnus){
     KayttajaOhjain::muutaKayttajaa($tunnus);
 });

 $app->post('/rekisteroi', function(){
     KayttajaOhjain::kasittele_rekisterointi();
 });
 
 $app->post('/uusi_alue', function(){
     AlueOhjain::uusiAlue();
 });
 
 