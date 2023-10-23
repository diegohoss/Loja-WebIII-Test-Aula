<?php

namespace Loja\WebIII\Service;

use Loja\WebIII\Model\Carrinho;
use Loja\WebIII\Model\Produto;

class ProcessaCompra 
{
    /** @var Carrinho */
    private $carrinho;
    /** @var int */
    private $totalDeProdutos;
    /** @var float */
    private $totalDaCompra;

    public function __construct()
    {
        $this->totalDaCompra = 0;
    }

    public function finalizaCompra(Carrinho $carrinho)
    {
        $this->carrinho = $carrinho;
        $produtos = $this->carrinho->getProdutos();
        foreach($produtos as $produto){
           $this->totalDaCompra = $this->totalDaCompra + $produto->getValor();
        }
        
    }

    public function getTotalDaCompra(): float
    {
        return $this->totalDaCompra;
    }

}