<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

 /*
  rowid Primaria	int(11)
  login varchar(50)
	employee	tinyint(4)
	login Índice	varchar(50)
	gender	varchar(10)
	civility	varchar(6)
	lastname	varchar(50)
	firstname	varchar(50)
	address	varchar(255)
	town	varchar(50)
	fk_state	int(11)
	fk_country	int(11)
	statut	tinyint(4)
	photo	varchar(255)
 */

include "usuario/usuario_doli_trait_props.php";

#[AllowDynamicProperties]
class UsuarioDolibarr extends LiteRecord {

  use UsuarioDoliTraitProps;

  public function __construct() 
  {
    parent::__construct();
    self::$table = PREFIJO_TABLAS_DOLIBARR.'users';
    self::$pk = 'rowid';
  }


  public function getUserGroups(int $user_id)
  { 
    $DQL = new OdaDql('UsuarioDolibarr');
    $DQL->setFrom(PREFIJO_TABLAS_DOLIBARR.'usergroup');
    $DQL->select('t.nom')
        ->where('t.rowid IN 
        (SELECT gu.fk_usergroup 
         FROM '.PREFIJO_TABLAS_DOLIBARR.'usergroup_user AS gu 
         WHERE gu.fk_user = ?)')
      ->setParams([$user_id]);
    return $DQL->execute();
  }

  // TODO: en desarrollo
  public function getDocentes()
  {
    $DQL = new OdaDql('UsuarioDolibarr');
    $DQL->setFrom(PREFIJO_TABLAS_DOLIBARR.'usergroup');
    $DQL->select("t.*")
      ->concat(['t.firstname', 't.lastname'], 'usuario_nombre')
      ->concat(['t.firstname', 't.lastname'], 'nombre')
      ->where('t.login<>t.documento')
      ->orderBy('t.??????');
    return $DQL->execute();
  }

}