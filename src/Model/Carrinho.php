<?php

namespace Loja\WebIII\Model;

class Carrinho
{
    /** @var Produto[] */
    private $produtos;
    /** @var Usuario */
    private $usuario;
    /** @var int */
    private $qtdProdutosCarrinho;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->produtos = [];
	    $this->qtdProdutosCarrinho = 0;
    }

    public function adicionaProduto(Produto $produto)
    {
        $this->produtos[] = $produto;
	    $this->qtdProdutosCarrinho = $this->qtdProdutosCarrinho + 1;
    }

    /**
     * @return Produto[]
     */
    public function getProdutos(): array
    {
        return $this->produtos;
    }
}
