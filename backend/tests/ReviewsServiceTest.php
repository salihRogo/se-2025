<?php

use PHPUnit\Framework\TestCase;

// Need to require these files since there's no namespace-based autoloading
require_once __DIR__ . '/../rest/services/ReviewsService.class.php';
require_once __DIR__ . '/../rest/dao/ReviewsDao.class.php';

class ReviewsServiceTest extends TestCase
{
    private $mockReviewsDao;
    private $reviewsService;

    protected function setUp(): void
    {
        // Create mock objects
        $this->mockReviewsDao = $this->createMock(ReviewsDao::class);
        
        // Create the service with mock DAO
        $this->reviewsService = new ReviewsService();
        
        // Use reflection to set private property
        $reflectionProperty = new ReflectionProperty(ReviewsService::class, 'reviewsDao');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->reviewsService, $this->mockReviewsDao);
    }

    public function testGetReviewsByShopId()
    {
        // Arrange
        $shopId = 2;
        $expectedReviews = [
            [
                'id' => 1,
                'user_id' => 1,
                'shop_id' => $shopId,
                'comment' => 'Great pastries and service!',
                'user_name' => 'John Doe'
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'shop_id' => $shopId,
                'comment' => 'Love the croissants here!',
                'user_name' => 'Jane Smith'
            ]
        ];
        
        // Set up the mock to return reviews when get_shop_reviews is called
        $this->mockReviewsDao->expects($this->once())
            ->method('get_shop_reviews')
            ->with($shopId)
            ->willReturn($expectedReviews);
        
        // Act
        $result = $this->reviewsService->get_shop_reviews($shopId);
        
        // Assert
        $this->assertSame($expectedReviews, $result);
        $this->assertCount(2, $result);
    }

    public function testAddReview()
    {
        // Arrange
        $reviewData = [
            'user_id' => 1,
            'shop_id' => 2,
            'comment' => 'The pastries here are amazing!'
        ];
        
        $expectedId = 3;
        
        // Set up the mock to return ID when add_review is called
        $this->mockReviewsDao->expects($this->once())
            ->method('add_review')
            ->with($reviewData)
            ->willReturn($expectedId);
        
        // Act
        $result = $this->reviewsService->add_review($reviewData);
        
        // Assert
        $this->assertEquals($expectedId, $result);
    }

    public function testDeleteReview()
    {
        // Arrange
        $reviewId = 1;
        
        // Set up the mock to return true when delete_review is called
        $this->mockReviewsDao->expects($this->once())
            ->method('delete_review')
            ->with($reviewId)
            ->willReturn(true);
        
        // Act
        $result = $this->reviewsService->delete_review($reviewId);
        
        // Assert
        $this->assertTrue($result);
    }

    public function testGetReviewsByUserId()
    {
        // Arrange
        $userId = 1;
        $expectedReviews = [
            [
                'id' => 1,
                'user_id' => $userId,
                'shop_id' => 2,
                'comment' => 'Great pastries and service!',
                'shop_name' => 'Pastry Shop 2'
            ],
            [
                'id' => 3,
                'user_id' => $userId,
                'shop_id' => 4,
                'comment' => 'Excellent cakes!',
                'shop_name' => 'Pastry Shop 4'
            ]
        ];
        
        // Set up the mock to return reviews when get_user_reviews is called
        $this->mockReviewsDao->expects($this->once())
            ->method('get_user_reviews')
            ->with($userId)
            ->willReturn($expectedReviews);
        
        // Act
        $result = $this->reviewsService->get_user_reviews($userId);
        
        // Assert
        $this->assertSame($expectedReviews, $result);
        $this->assertCount(2, $result);
    }
}
