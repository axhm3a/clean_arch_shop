<?php

namespace Bws\Interactor;

use Bws\Entity\ArticleStub;
use Bws\Entity\BasketStub;
use Bws\Entity\EmptyBasketStub;
use Bws\Repository\BasketPositionRepositoryMock;
use Bws\Repository\BasketRepositoryMock;

class ViewBasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BasketPositionRepositoryMock
     */
    private $basketPositionRepository;

    /**
     * @var BasketRepositoryMock
     */
    private $basketRepository;

    /**
     * @var ViewBasket
     */
    private $interactor;

    public function setUp()
    {
        $this->basketPositionRepository = new BasketPositionRepositoryMock();
        $this->basketRepository         = new BasketRepositoryMock();
        $this->interactor               = new ViewBasket($this->basketRepository, $this->basketPositionRepository);
    }

    public function testBadBasketId()
    {
        $result = $this->interactor->execute(null);
        $this->assertEquals(ViewBasketResponse::BAD_BASKET_ID, $result->getCode());
        $this->assertEquals('0.00', $result->getTotal());
    }

    public function testBasketNotFound()
    {
        $result = $this->interactor->execute(999);
        $this->assertEquals(ViewBasketResponse::BASKET_NOT_FOUND, $result->getCode());
    }

    public function testEmptyBasket()
    {
        $result = $this->interactor->execute(EmptyBasketStub::ID);
        $this->assertEquals(ViewBasketResponse::SUCCESS, $result->getCode());
        $this->assertEquals(array(), $result->getPositions());
        $this->assertEquals(0, $result->getPositionCount());
        $this->assertEquals(0.00, $result->getTotal());
    }

    public function testFilledBasket()
    {
        $result = $this->interactor->execute(BasketStub::ID);
        $this->assertEquals(ViewBasketResponse::SUCCESS, $result->getCode());
        $this->assertEquals(
            array(
                array(
                    'articleId'    => ArticleStub::ID,
                    'articleTitle' => ArticleStub::TITLE,
                    'articlePrice' => ArticleStub::PRICE,
                    'articleImage' => ArticleStub::IMAGE_PATH,
                    'totalPrice'   => '9.99',
                    'count'        => 1
                )
            ),
            $result->getPositions()
        );
        $this->assertEquals(1, $result->getPositionCount());
        $this->assertEquals('9.99', $result->getTotal());
        $this->assertEquals('', $result->getMessage());
    }
}
 