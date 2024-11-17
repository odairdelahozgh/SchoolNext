<?php
class IndexController extends AppController
{
  protected function before_filter() 
  {
    View::template(null);
  }

  public function index() 
  {
  }

}