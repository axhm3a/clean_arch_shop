<?php

namespace Bws\Interactor;

use Bws\Entity\ArticleStub;
use Bws\Repository\ArticleRepositoryMock;
use Bws\Repository\BasketPositionRepositoryMock;
use Bws\Repository\BasketRepositoryMock;

class AddToBasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArticleRepositoryMock
     */
    private $articleRepository;

    /**
     * @var BasketRepositoryMock
     */
    private $basketRepository;

    /**
     * @var BasketPositionRepositoryMock
     */
    private $basketPositionRepository;

    /**
     * @var AddToBasket
     */
    private $interactor;

    public function setUp()
    {
        $this->articleRepository        = new ArticleRepositoryMock();
        $this->basketRepository         = new BasketRepositoryMock();
        $this->basketPositionRepository = new BasketPositionRepositoryMock();

        $this->interactor = new AddToBasket(
            $this->articleRepository,
            $this->basketPositionRepository,
            $this->basketRepository
        );
    }

    /**
     * @param AddToBasketResponse $response
     * @param int                 $code
     */
    protected function assertResponseCode(AddToBasketResponse $response, $code)
    {
        $this->assertEquals($code, $response->getCode());
    }

    public function testReturnsMissingBasketIdIfRequestBasketIdIsNull()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(5, 1, null));
        $this->assertResponseCode($response, AddToBasketResponse::BAD_BASKET_ID);
    }

    public function testReturnsZeroCountIfRequestCountZeroWhichIsValidButCountMustNotBeZero()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(5, 0, 0));
        $this->assertResponseCode($response, AddToBasketResponse::ZERO_COUNT);
    }

    public function testReturnsZeroCountIfRequestCountNullWhichIsValidButCountMustNotBeZero()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(5, null, 12345));
        $this->assertResponseCode($response, AddToBasketResponse::ZERO_COUNT);
    }

    public function testReturnsBadArticleIdIfRequestArticleIdIsNull()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(null, 1, 12356));
        $this->assertResponseCode($response, AddToBasketResponse::BAD_ARTICLE_ID);
    }

    public function testArticleNotFound()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(123, 1, 12356));
        $this->assertResponseCode($response, AddToBasketResponse::ARTICLE_NOT_FOUND);
    }

    public function testSuccessfulAdditionWithMergePositions()
    {
        $response = $this->interactor->execute(new AddToBasketRequest(ArticleStub::ID, 1, 12356));

        $this->assertResponseCode($response, AddToBasketResponse::SUCCESS);
        $this->assertSame('9.99', $response->getTotal());
        $this->assertNotEquals(12356, $response->getBasketId());
        $this->assertSame(1, $response->getPosCount());
        $this->assertSame(12356, $this->basketRepository->getFindByIdArgument());
        $this->assertSame(1, $this->basketPositionRepository->getAddToBasketCalls());
        $this->assertSame('', $response->getMessage());

        $response = $this->interactor->execute(new AddToBasketRequest(ArticleStub::ID, 1, 12356));

        $this->assertResponseCode($response, AddToBasketResponse::SUCCESS);
        $this->assertSame('19.98', $response->getTotal());
        $this->assertNotEquals(12356, $response->getBasketId());
        $this->assertSame(1, $response->getPosCount());
        $this->assertSame(12356, $this->basketRepository->getFindByIdArgument());
        $this->assertSame(2, $this->basketPositionRepository->getAddToBasketCalls());
        $this->assertSame('', $response->getMessage());
    }
}
 