<?php
namespace Loja\WebIII\Tests\Service;

use Loja\WebIII\Model\Carrinho;
use Loja\WebIII\Model\Produto;
use Loja\WebIII\Model\Usuario;
use Loja\WebIII\Service\ProcessaCompra;
use PHPUnit\Framework\TestCase;


class ProcessaCompraTest extends TestCase {


    public function testUm(){
        // Arrange - Given
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));
        $compra = new ProcessaCompra();
        // Act - When
        $compra->finalizaCompra($carrinho);
        $totalDaCompra = $compra->getTotalDaCompra();
        // Assert - Then
        $totalEsperado = 6600;
        $this->assertEquals($totalEsperado, $totalDaCompra);
        /*
        echo PHP_EOL;
        if($totalDaCompra == $totalEsperado){
        echo "TESTE PASSOU".PHP_EOL;
        }
        else{
        echo "TESTE FALHOU".PHP_EOL;
        }
        */
    }

    public function testVerificaSe_AQuantidadeDeProdutosEmCompraECarrinho_SaoIguais() {
        // Arrange - Given - Prepara o cenario de teste
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));
        $compra = new ProcessaCompra();
        // Act - When - Executa o teste
        $compra->finalizaCompra($carrinho);
        $totalDeProdutos = $compra->getTotalDeProdutos();
        // Assert - Then - Verifica-se a saida e a esperada
        $totalEsperado = 3;

        self::assertEquals($totalEsperado, $totalDeProdutos);
    }

    public function testVerificaSe_OProdutoDeMaiorValorNoCarrinho_EstaCorreto() {
        // Arrange - Given - Prepara o cenario de teste
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));
        $compra = new ProcessaCompra();
        // Act - When - Executa o teste
        $compra->finalizaCompra($carrinho);

        $produtoDeMaiorValor = $compra->getProdutoDeMaiorValor();
        // Assert - Then - Verifica-se a saida e a esperada
        $totalEsperado = 4500;

        self::assertEquals($totalEsperado, $produtoDeMaiorValor);
}


    public function testVerificaSe_OProdutoDeMenorValorNoCarrinho_EstaCorreto() {
    // Arrange - Given - Prepara o cenario de teste
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));
        $compra = new ProcessaCompra();
        // Act - When - Executa o teste
        $compra->finalizaCompra($carrinho);
        $produtoDeMenorValor = $compra->getProdutoDeMenorValor();
        // Assert - Then - Verifica-se a saida e a esperada
        $totalEsperado = 600;
        self::assertEquals($totalEsperado, $produtoDeMenorValor);
    }
}