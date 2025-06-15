<?php

use PHPUnit\Framework\TestCase;

// Need to require these files since there's no namespace-based autoloading
require_once __DIR__ . '/../rest/services/FavouritesService.class.php';
require_once __DIR__ . '/../rest/dao/FavouritesDao.class.php';

class FavouritesServiceTest extends TestCase
{
    private $mockFavouritesDao;
    private $favouritesService;

    protected function setUp(): void
    {
        // Create mock objects
        $this->mockFavouritesDao = $this->createMock(FavouritesDao::class);
        
        // Create the service with mock DAO
        $this->favouritesService = new FavouritesService();
        
        // Use reflection to set private property
        $reflectionProperty = new ReflectionProperty(FavouritesService::class, 'favouritesDao');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->favouritesService, $this->mockFavouritesDao);
    }

    public function testGetFavouritesByUserId()
    {
        // Arrange
        $userId = 1;
        $expectedFavourites = [
            [
                'id' => 1,
                'user_id' => $userId,
                'shop_id' => 2,
                'shop_name' => 'Pastry Shop 2',
                'created_at' => '2023-11-10 10:15:30'
            ],
            [
                'id' => 3,
                'user_id' => $userId,
                'shop_id' => 5,
                'shop_name' => 'Pastry Shop 5',
                'created_at' => '2023-11-12 16:20:45'
            ]
        ];
        
        // Set up the mock to return favourites when get_user_favourites is called
        $this->mockFavouritesDao->expects($this->once())
            ->method('get_user_favourites')
            ->with($userId)
            ->willReturn($expectedFavourites);
        
        // Act
        $result = $this->favouritesService->get_user_favourites($userId);
        
        // Assert
        $this->assertSame($expectedFavourites, $result);
        $this->assertCount(2, $result);
    }

    public function testAddFavourite()
    {
        // Arrange
        $favouriteData = [
            'user_id' => 1,
            'shop_id' => 3
        ];
        
        $expectedId = 4;
        
        // Set up the mock to return ID when add_favourites is called
        $this->mockFavouritesDao->expects($this->once())
            ->method('add_favourites')
            ->with($favouriteData)
            ->willReturn($expectedId);
        
        // Act
        $result = $this->favouritesService->add_favourites($favouriteData);
        
        // Assert
        $this->assertEquals($expectedId, $result);
    }

    public function testDeleteFavourite()
    {
        // Arrange
        $favouriteId = 2;
        
        // Set up the mock to return true when delete_favourite is called
        $this->mockFavouritesDao->expects($this->once())
            ->method('delete_favourite')
            ->with($favouriteId)
            ->willReturn(true);
        
        // Act
        $result = $this->favouritesService->delete_favourite($favouriteId);
        
        // Assert
        $this->assertTrue($result);
    }
}
