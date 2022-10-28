<?php


namespace App\Service;


class ArticlesService
{
  private $globalVariables;

  public function __construct(TwigGlobalVariables $globalVariables)
  {
    $this->globalVariables = $globalVariables;
  }

  public function toto(){
    $categories = $this->globalVariables->getCategories();
  }

}
