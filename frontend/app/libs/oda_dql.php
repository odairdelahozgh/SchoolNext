<?php

class OdaDql {
  private string $_select      = '';
  private string $_from        = ''; //salones
  private string $_from_source = ''; //web_salones
  private string $_from_alias  = ''; //s
  private string $_where       = '';
  private string $_order_by    = '';
  private array  $_joins       = [];
  private array  $_params      = [];

  public function __toString() { 
    return $this->render();
  }
  
  /**
   * Muestra la consulta SQL
   */
  public function render(): string {    
    return 'SELECT '
        . ((empty($this->_select) or ('*'==$this->_select)) ? 't.*' : $this->_select)
        . (empty($this->_from) ? '<<FALTA Cláusula From>>' : " FROM $this->_from_source AS $this->_from_alias")
        . implode(" ", $this->_joins)
        . (empty($this->_where) ? '' : " WHERE $this->_where ")
        . (empty($this->_order_by) ? '' : " ORDER BY $this->_order_by");
  }
  
  
  /**
   * Ejecuta la consulta SQL
   */
  public function execute(bool $write_log = false): array|string {
    try {
      if ($write_log) {
        OdaLog::debug(msg: $this->render());
        OdaLog::debug(msg: 'Params: ' .$this->getParams() );
      }
      return (new $this->_from)->all($this->render(), $this->_params);
    } catch (Exception $e) {
      
      OdaLog::debug(msg: 'Excepción capturada: ');
      OdaLog::debug(msg: $this->render() );
      OdaLog::debug(msg: 'RECUERDA: tabla principal = t');

      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
  } 

  /**
   * 
   */
  public function select(string $select) {
    $this->_select = (empty($select) or ('*'==$select)) ? 't.*' : $select;
    return $this;
  }

  /**
   * 
   */
  public function addSelect(string $select) {
    if (empty($this->_select)) {
      $this->_select = $select;
    } else {
      $this->_select .= ", $select";
    }
    return $this;
  }

  
  /**
   * 
   */
  public function concat(array $concat=[], string $alias='') {
    $str = '';
    $cnt = count($concat);
    IF ($cnt>0) {
      $str = "CONCAT($concat[0], ' '";
      for ($i=1; $i<$cnt-1; $i++) {
        $str .= ", $concat[$i], ' '";
      }
      $str .= ', '.$concat[$cnt-1].") AS $alias";
    }

    if (empty($this->_select)) {
      $this->_select = $str;
    } else {
      $this->_select .= ", $str";
    }
    return $this;
  }
  

  /**
   * @example $qb->from('Phonenumber', 'p')
   * @example $qb->from('Phonenumber', 'p', 'p.id')
   */
  public function from(string $from_class, string $alias='t') {
    $this->_from   = OdaUtils::camelcase(trim($from_class)); // Nombre del modelo
    $this->_from_source = Config::get("tablas.".strtolower(OdaUtils::smallcase($this->_from)) );
    $this->_from_alias  = $alias;
    return $this;
  }
  
  /**
   * @example $qb->innerJoin('u.Group', 'g', Expr\Join::WITH, $qb->expr()->eq('u.status_id', '?1'))
   * @example $qb->innerJoin('u.Group', 'g', 'WITH', 'u.status = ?1')
   * @example $qb->innerJoin('u.Group', 'g', 'WITH', 'u.status = ?1', 'g.id')
   */
  public function leftJoin(string $table_singular, string $alias, $condition = null) {
    $table_singular = OdaUtils::singularize(strtolower(trim($table_singular)));
    
    $join = " LEFT JOIN ". Config::get("tablas.$table_singular") ." AS $alias ";
    if (is_null($condition)) { $condition = 't.'.$table_singular.'_id'; }
    $join .= " ON $condition=$alias.id ";
    
    $this->_joins[]=$join;
    return $this;
  }

  /**
   * NOTE: ->where() overrides all previously set conditions
   * @example $qb->where('u.firstName = ?1', $qb->expr()->eq('u.surname', '?2'))
   * @example $qb->where($qb->expr()->andX($qb->expr()->eq('u.firstName', '?1'), $qb->expr()->eq('u.surname', '?2')))
   * @example $qb->where('u.firstName = ?1 AND u.surname = ?2')
   */
  public function where(string $where) {
    $this->_where = $where;
    return $this;
  }

  /**
   * NOTE: ->andWhere() can be used directly, without any ->where() before
   * @example - $qb->andWhere($qb->expr()->orX($qb->expr()->lte('u.age', 40), 'u.numChild = 0'))
   */
  public function andWhere(string $where) {
    $this->_where = ($this->_where) ? "($this->_where) AND ($where)" : $where;
    return $this;
  }


  /**
   * @example - $qb->orWhere($qb->expr()->between('u.id', 1, 10));
   */
  public function orWhere(string $where) {
    $this->_where = ($this->_where) ? "($this->_where) OR ($where)" : $where;
    return $this;
  }


  /**
   * NOTE: -> orderBy() overrides all previously set ordering conditions
   * $qb->orderBy('u.surname', 'DESC')
   */
  public function orderBy(string $sort){
    $this->_order_by = $sort;
    return $this;
  }

  /**
   * @example  $qb->addOrderBy('u.firstName')
   */
  public function addOrderBy(string $sort) {
    $this->_order_by = ($this->_order_by) ? "$this->_order_by, $sort" : $sort;
    // Default $order = 'ASC'
    return $this;
  } 

  /**
   *
   */
  public function setParams($params=[]) {
    array_push($this->_params, ...$params);
    return $this;
  }
  
  /**
   *
   */
  public function getParams() {
    return "[".implode(',', $this->_params).']';
  }

} // END-CLASS-OdaDQL
