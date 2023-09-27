<?php

enum TipoDql: int {
  case Select = 1;
  case Update = 2;
  case Insert = 3;
  case Delete = 4;
}

class OdaDql {
  private string $_select      = '';
  private string $_sets        = '';
  private string $_from_source = ''; //ej: web_salones
  private string $_where       = '';
  private string $_order_by    = '';
  private string $_group_by    = '';
  private array  $_joins       = [];
  private array  $_params      = [];
  private int $_limit = 0;
  private string $_inserts_cols     = '';
  private string $_inserts_vals     = '';

  public function __construct(private string $_from, private TipoDql $_tipo_dql = TipoDql::Select) {
    $this->_from_source = $_from::getSource() ?? $_from;
  } // END-__construct()

  public function __toString() { return $this->render(); }
  
  public function render(): string {
    return match($this->_tipo_dql) {
      TipoDql::Select => 'SELECT '
              . ((empty($this->_select) or ('*'==$this->_select)) ? 't.*' : $this->_select)
              . " FROM $this->_from_source AS t"
              . implode(" ", $this->_joins)
              . (empty($this->_where)    ? '' : " WHERE $this->_where ")
              . (empty($this->_group_by) ? '' : " GROUP BY $this->_group_by")
              . (empty($this->_order_by) ? '' : " ORDER BY $this->_order_by")
              . (empty($this->_limit)    ? '' : " LIMIT $this->_limit"),

      TipoDql::Update => "UPDATE $this->_from_source AS t"
              . (empty($this->_sets) ? '-ERROR NO SET-' : " SET $this->_sets")
              . (empty($this->_where) ? '' : " WHERE $this->_where"),
      
      TipoDql::Insert => "INSERT INTO $this->_from_source "
      . (empty($this->_inserts_cols) ? '-ERROR NO SET-' : " ($this->_inserts_cols) VALUES ($this->_inserts_vals) "),

    };
  } //END-render()
  
  
  public function renderlog(): string {
    return match($this->_tipo_dql) {
      TipoDql::Select => 'SELECT '.PHP_EOL
              . ((empty($this->_select) or ('*'==$this->_select)) ? 't.*' : $this->_select).PHP_EOL
              . " FROM $this->_from_source AS t".PHP_EOL
              . implode(" ", $this->_joins).PHP_EOL
              . (empty($this->_where) ? '' : " WHERE $this->_where ").PHP_EOL
              . (empty($this->_group_by) ? '' : " GROUP BY $this->_group_by").PHP_EOL
              . (empty($this->_order_by) ? '' : " ORDER BY $this->_order_by")
              . (empty($this->_limit)    ? '' : " LIMIT $this->_limit"),

      TipoDql::Update => "UPDATE $this->_from_source AS t".PHP_EOL
              . (empty($this->_sets) ? '-ERROR NO SET-' : " SET $this->_sets").PHP_EOL
              . (empty($this->_where) ? '' : " WHERE $this->_where"),
      
      TipoDql::Insert => "INSERT INTO $this->_from_source "
              . (empty($this->_inserts_cols) ? '-ERROR NO SET-' : " ($this->_inserts_cols) VALUES ($this->_inserts_vals) "),
    };
  } //END-renderlog()

  public function execute(bool $write_log = false): array|string {
    try {
      if ($write_log) { 
        OdaLog::debug($this->renderlog().PHP_EOL.'Params: ' .$this->getParams());
      }
      return (new $this->_from)->all($this->render(), $this->_params);
      
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  } //END-execute
  
  public function executeFirst(bool $write_log = false): array|string {
    try {
      if ($write_log) {
        OdaLog::debug($this->renderlog().PHP_EOL.'Params: ' .$this->getParams());
      }
      return (new $this->_from)->first($this->render(), $this->_params);
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  } //END-executeFirst
  
  public function getLastInsertId() {
    return (new $this->_from)->first("SELECT MAX(id) as last_id FROM $this->_from_source");
  }

  public function select(string $select) {
    $this->_select = (empty($select) or ('*'==$select)) ? 't.*' : $select;
    $this->_tipo_dql  = TipoDql::Select;
    return $this;
  } //END-select

  public function addSelect(string $select) {
    if (empty($this->_select)) { $this->_select = $select; } 
    else { $this->_select .= ", $select"; }

    $this->_tipo_dql  = TipoDql::Select;
    return $this;
  } //END-addSelect

  public function update(array $arr_values) {
    $sets = '';
    foreach ($arr_values as $key => $value) {
      //if (!empty($value)) { 
        $sets .= " t.$key='$value',"; 
      //}
    }
    
    $this->_sets = substr($sets, 0, strlen($sets)-1);
    $this->_tipo_dql  = TipoDql::Update;
    return $this;
  } //END-update


  public function addUpdate(array $arr_values) {
    $sets = '';
    foreach ($arr_values as $key => $value) { 
      //if (!empty($value)) { 
        $sets .= " t.$key='$value',"; 
      //}
    }
    
    if (empty($this->_sets)) { $this->_sets = substr($sets, 0, strlen($sets)-1); } 
    else { $this->_sets .= ', '.substr($sets, 0, strlen($sets)-1); }

    $this->_tipo_dql  = TipoDql::Update;
    return $this;
  } //END-addUpdate

  public function insert(array $arr_values) {
    $cols = '';  $vals = '';
    foreach ($arr_values as $key => $value) { 
      $cols .= " $key,";
      $vals .= " '$value',";
    }
    $this->_inserts_cols = substr($cols, 0, strlen($cols)-1);
    $this->_inserts_vals = substr($vals, 0, strlen($vals)-1);
    $this->_tipo_dql  = TipoDql::Insert;
    return $this;
  } //END-insert

  public function addInsert(array $arr_values) {
    $cols = '';
    $vals = '';
    foreach ($arr_values as $key => $value) { 
      $cols .= " $key,";
      $vals .= " '$value',";
    }
    if (empty($this->_inserts_cols)) {
      $this->_inserts_cols = substr($cols, 0, strlen($cols)-1);
      $this->_inserts_vals = substr($vals, 0, strlen($vals)-1);
    } else { 
      $this->_inserts_cols .= ', '.substr($cols, 0, strlen($cols)-1);
      $this->_inserts_vals .= ', '.substr($vals, 0, strlen($vals)-1);
    }

    $this->_tipo_dql  = TipoDql::Insert;
    return $this;
  } //END-addInsert

  public function concat(array $concat=[], string $alias='') {
    $str = '';
    $cnt = count($concat);
    if ($cnt>0) {
      $str = "CONCAT($concat[0], ' '";
      for ($i=1; $i<$cnt-1; $i++) { $str .= ", $concat[$i], ' '"; }
      $str .= ', '.$concat[$cnt-1].") AS $alias";
    }

    if (empty($this->_select)) {
      $this->_select = $str;
    } else {
      $this->_select .= ", $str";
    }
    $this->_tipo_dql  = TipoDql::Select;
    return $this;
  } //END-concat
  
  public function leftJoin(string $table_singular, string $alias, $condition = null) {
    $table_singular = OdaUtils::singularize(strtolower(trim($table_singular)));
    $join = " LEFT JOIN ". Config::get("tablas.$table_singular") ." AS $alias ";
    if (is_null($condition)) { $condition = "t.$table_singular"."_id=$alias.id"; }
    $join .= " ON $condition ";
    $this->_joins[]=$join;
    return $this;
  } //END-leftJoin()

  public function where(string $where) {
    $this->_where = $where;
    return $this;
  } //END-where

  public function andWhere(string $where) {
    $this->_where = ($this->_where) ? "($this->_where) AND ($where)" : $where;
    return $this;
  } //END-andWhere

  public function orWhere(string $where) {
    $this->_where = ($this->_where) ? "($this->_where) OR ($where)" : $where;
    return $this;
  } //END-orWhere

  public function orderBy(string $sort){
    $this->_order_by = $sort;
    return $this;
  } //END-orderBy

  public function addOrderBy(string $sort) {
    $this->_order_by = ($this->_order_by) ? "$this->_order_by, $sort" : $sort;
    // Default $order = 'ASC'
    return $this;
  } //END-addOrderBy

  public function groupBy(string $group){
    $this->_group_by = $group;
    return $this;
  } //END-groupBy

  public function setParams($params=[]) {
    array_push($this->_params, ...$params);
    return $this;
  } //END-setParams
  
  public function getParams() {
    return '['.implode(',', $this->_params).']';
  } //END-getParams


  public function setFrom(string $nombre_tabla): void {
    $this->_from_source = $nombre_tabla;
  }

  
  public function setLimit(int $limite_regs): void {
    $this->_limit = $limite_regs;
  }

  
} // END-CLASS
