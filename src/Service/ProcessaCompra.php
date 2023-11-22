<?php

namespace Loja\WebIII\Service;

use Loja\WebIII\Model\Carrinho;
use Loja\WebIII\Model\Produto;

class ProcessaCompra {

    /** @var Carrinho */
    private $carrinho;
    /** @var int */
    private $totalDeProdutos;
    /** @var float */
    private $totalDaCompra;
    private $menorValor, $maiorValor;

    public function __construct() {
        $this->totalDaCompra = 0;
        $this->menorValor = PHP_FLOAT_MAX; // Inicializa com o maior valor possível
        $this->maiorValor = 0; // Inicializa com o menor valor possível
    }

    public function processaProduto(Produto $produto) {
        if ($produto->getValor() > $this->maiorValor) {
            $this->maiorValor = $produto->getValor();
        } elseif ($produto->getValor() < $this->menorValor) {
            $this->menorValor = $produto->getValor();
        }
    }

    public function getProdutoDeMaiorValor(): float {
        return $this->maiorValor;
    }

    public function getProdutoDeMenorValor(): float {
        return $this->menorValor;
    }

    public function finalizaCompra(Carrinho $carrinho) {
        $this->carrinho = $carrinho;
        $produtos = $this->carrinho->getProdutos();
        foreach ($produtos as $produto) {
            $this->totalDaCompra += $produto->getValor();
            $this->processaProduto($produto);
        }
    }

    public function getTotalDaCompra(): float {
        return $this->totalDaCompra;
    }
}
