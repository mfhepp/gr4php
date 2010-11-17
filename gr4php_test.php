<?php
include_once 'gr4php.php';
include_once 'gr4php_configuration.php';

$gr4php=new GR4PHP(GR4PHP_Configuration::Endpoint_LOC);

print_r($gr4php->getCompany(array("keyword"=>"dvd player")));
