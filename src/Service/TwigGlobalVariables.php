<?php


namespace App\Service;


use App\Repository\CategoryRepository;

class TwigGlobalVariables
{
  /**
   * @var \App\Repository\CategoryRepository
   */
  private $categoryRepo;

  public function __construct(CategoryRepository $categoryRepository)
  {
    $this->categoryRepo = $categoryRepository;
  }

  public function getCategories(): array
  {
    return $this->categoryRepo->findAll();
  }
}
