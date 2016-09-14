<?php
namespace Robincw\Worker\Domain;

interface Consumer
{
    public function consume();
}