<?php

use PHPUnit\Framework\TestCase;

// Need to require these files since there's no namespace-based autoloading
require_once __DIR__ . '/../rest/services/ShopsService.class.php';
require_once __DIR__ . '/../rest/dao/ShopsDao.class.php';

class ShopsServiceTest extends TestCase
{
    private $mockShopsDao;
    private $shopsService;

    protected function setUp(): void
    {
        // Create mock objects
        $this->mockShopsDao = $this->createMock(ShopsDao::class);
        
        // Create the service with mock DAO
        $this->shopsService = new ShopsService();
        
        // Use reflection to set private property
        $reflectionProperty = new ReflectionProperty(ShopsService::class, 'shopsDao');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->shopsService, $this->mockShopsDao);
    }

    public function testGetShopById()
    {
        // Arrange
        $shopId = 1;
        $expectedShop = [
            'id' => $shopId,
            'name' => 'Test Pastry Shop',
            'address' => '123 Baker Street',
            'city' => 'Test City',
            'contact_number' => '123-456-7890',
            'opens_at' => '08:00:00',
            'closes_at' => '20:00:00',
            'description' => 'A test pastry shop',
            'image_url' => 'shop1.jpg'
        ];
        
        // Set up the mock to return a shop when get_shop_by_id is called
        $this->mockShopsDao->expects($this->once())
            ->method('get_shop_by_id')
            ->with($shopId)
            ->willReturn($expectedShop);
        
        // Act
        $result = $this->shopsService->get_shop_by_id($shopId);
        
        // Assert
        $this->assertSame($expectedShop, $result);
    }

    public function testGetAllShops()
    {
        // Arrange
        $expectedShops = [
            [
                'id' => 1,
                'name' => 'Test Pastry Shop 1',
                'address' => '123 Baker Street',
                'city' => 'Test City',
                'contact_number' => '123-456-7890',
                'opens_at' => '08:00:00',
                'closes_at' => '20:00:00',
                'description' => 'A test pastry shop',
                'image_url' => 'shop1.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Test Pastry Shop 2',
                'address' => '456 Dessert Avenue',
                'city' => 'Sweet City',
                'contact_number' => '987-654-3210',
                'opens_at' => '09:00:00',
                'closes_at' => '21:00:00',
                'description' => 'Another test pastry shop',
                'image_url' => 'shop2.jpg'
            ]
        ];
        
        // Set up the mock to return shops when get_all_shops is called
        $this->mockShopsDao->expects($this->once())
            ->method('get_all_shops')
            ->willReturn($expectedShops);
        
        // Act
        $result = $this->shopsService->get_all_shops();
        
        // Assert
        $this->assertSame($expectedShops, $result);
        $this->assertCount(2, $result);
    }

    public function testAddShop()
    {
        // Arrange
        $shopData = [
            'name' => 'New Pastry Shop',
            'address' => '789 Pastry Lane',
            'city' => 'New City',
            'contact_number' => '555-123-4567',
            'opens_at' => '07:00:00',
            'closes_at' => '19:00:00',
            'description' => 'A brand new pastry shop',
            'image_url' => 'new_shop.jpg'
        ];
        
        $expectedId = 3;
        
        // Set up the mock to return ID when add_shop is called
        $this->mockShopsDao->expects($this->once())
            ->method('add_shop')
            ->with($shopData)
            ->willReturn($expectedId);
        
        // Act
        $result = $this->shopsService->add_shop($shopData);
        
        // Assert
        $this->assertEquals($expectedId, $result);
    }
}
