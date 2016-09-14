<?php
namespace Robincw\Worker\Domain;

interface Producer
{
    public function produce($message);
}