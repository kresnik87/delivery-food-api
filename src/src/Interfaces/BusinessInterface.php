<?php

namespace App\Interfaces;
use App\Entity\Bussines;

interface BusinessInterface
{
  public function getBussines(): ?Bussines;
}
