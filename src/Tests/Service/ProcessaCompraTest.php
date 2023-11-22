<?php
namespace Loja\WebIII\Tests\Service;

use Loja\WebIII\Model\Carrinho;
use Loja\WebIII\Model\Produto;
use Loja\WebIII\Model\Usuario;
use Loja\WebIII\Service\ProcessaCompra;
use PHPUnit\Framework\TestCase;

class ProcessaCompraTest extends TestCase
{
    private $compra;

    public function setUp(): void{

        $this->compra = new ProcessaCompra();

    }

    public function testUm()
    {
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));
        $this->compra->finalizaCompra($carrinho);
        $totalDaCompra = $this->compra->getTotalDaCompra();
        $totalEsperado = 6600;
        $this->assertEquals($totalEsperado, $totalDaCompra);
    }

    /**
     * @dataProvider carrinhoComProdutos
     */
    public function testVerificaSe_AQuantidadeDeProdutosEmCompraECarrinho_SaoIguais(Carrinho $carrinho)
    {
        $this->compra->finalizaCompra($carrinho);
        $totalDeProdutosDaCompra = $this->compra->getTotalDeProdutos();
        $totalEsperado = $carrinho->getTotalDeProdutos();
        self::assertEquals($totalEsperado, $totalDeProdutosDaCompra);
    }

    /**
     * @dataProvider carrinhoComProdutos
     */
    public function testVerificaSe_OValorTotalDaCompraEASomaDosProdutosDoCarrinho_SaoIguais(Carrinho $carrinho)
    {
        $this->compra->finalizaCompra($carrinho);
        $totalDaCompra = $this->compra->getTotalDaCompra();
        $totalEsperado = $carrinho->getValorTotalProdutos();
        self::assertEquals($totalEsperado, $totalDaCompra);
    }

    /**
     * @dataProvider carrinhoComProdutos
     */
    public function testVerificaSe_OProdutoDeMaiorValorNoCarrinho_EstaCorreto(Carrinho $carrinho)
    {
        $this->compra->finalizaCompra($carrinho);
        $produtoDeMaiorValor = $this->compra->getProdutoDeMaiorValor();
        $totalEsperado = 4500;
        self::assertEquals($totalEsperado, $produtoDeMaiorValor);
    }

    /**
     * @dataProvider carrinhoComProdutos
     */
    public function testVerificaSe_OProdutoDeMenorValorNoCarrinho_EstaCorreto(Carrinho $carrinho)
    {
        $this->compra->finalizaCompra($carrinho);
        $produtoDeMenorValor = $this->compra->getProdutoDeMenorValor();
        $totalEsperado = 600;
        self::assertEquals($totalEsperado, $produtoDeMenorValor);
    }

    public function carrinhoComProdutos()
    {
        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $pedro = new Usuario('Pedro');

        $carrinhoOrdemCrescente = new Carrinho($maria);
        $carrinhoOrdemCrescente->adicionaProduto(new Produto('Cooktop', 600));
        $carrinhoOrdemCrescente->adicionaProduto(new Produto('Geladeira', 1000));
        $carrinhoOrdemCrescente->adicionaProduto(new Produto('FornoEletrico', 2500));
        $carrinhoOrdemCrescente->adicionaProduto(new Produto('Fogao', 3000));
        $carrinhoOrdemCrescente->adicionaProduto(new Produto('Pia', 4500));

        $carrinhoOrdemDecrescente = new Carrinho($pedro);
        $carrinhoOrdemDecrescente->adicionaProduto(new Produto('Pia', 4500));
        $carrinhoOrdemDecrescente->adicionaProduto(new Produto('Fogao', 3000));
        $carrinhoOrdemDecrescente->adicionaProduto(new Produto('FornoEletrico', 2500));
        $carrinhoOrdemDecrescente->adicionaProduto(new Produto('Geladeira', 1000));
        $carrinhoOrdemDecrescente->adicionaProduto(new Produto('Cooktop', 600));

        $carrinhoOrdemAleatoria = new Carrinho($joao);
        $carrinhoOrdemAleatoria->adicionaProduto(new Produto('FornoEletrico', 2500));
        $carrinhoOrdemAleatoria->adicionaProduto(new Produto('Geladeira', 1000));
        $carrinhoOrdemAleatoria->adicionaProduto(new Produto('Pia', 4500));
        $carrinhoOrdemAleatoria->adicionaProduto(new Produto('Cooktop', 600));
        $carrinhoOrdemAleatoria->adicionaProduto(new Produto('Fogao', 3000));

        return [
            'carrinho Aleatorio' => [$carrinhoOrdemAleatoria],
            'carrinho Crescente' => [$carrinhoOrdemCrescente],
            'carrinho Decrescente' => [$carrinhoOrdemDecrescente],
        ];
    }

    
    public function testObtemProdutoDeMaiorValorNoCarrinho() {

        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));

        $produtoDeMaiorValor = $carrinho->getProdutoDeMaiorValor();
        $totalEsperado = 4500;
        
        self::assertEquals($totalEsperado, $produtoDeMaiorValor);
    }


    public function testObtemProdutoDeMenorValorNoCarrinho()
    {
        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);
        $carrinho->adicionaProduto(new Produto('Geladeira', 1500));
        $carrinho->adicionaProduto(new Produto('Cooktop', 600));
        $carrinho->adicionaProduto(new Produto('Forno Eletrico', 4500));

        $produtoDeMenorValor = $carrinho->getProdutoDeMenorValor();
        $totalEsperado = 600;
        
        self::assertEquals($totalEsperado, $produtoDeMenorValor);
    }

    public function testFinalizaCompraSemProdutosNoCarrinho() {

        $maria = new Usuario('Maria');
        $carrinho = new Carrinho($maria);

        $compra = new ProcessaCompra();
        $compra->finalizaCompra($carrinho);

        $totalDaCompra = $compra->getTotalDaCompra();
        $totalEsperado = 0;

        self::assertEquals($totalEsperado, $totalDaCompra);
    }

}
