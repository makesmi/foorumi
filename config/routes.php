<?php

  $app->get('/', function() {
    HelloWorldController::etusivu();
  });

  $app->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $app->get('/etusivu', function() {
      HelloWorldController::etusivu();
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
  
  $app->get('/rekist', function() {
      HelloWorldController::rekist();
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
  
 $app->post('/kirjaudu', function(){
     KayttajaOhjain::kirjaudu();
 });
  
 $app->post('/muuta_kayttajaa/:tunnus', function($tunnus){
     KayttajaOhjain::muutaKayttajaa($tunnus);
 });
