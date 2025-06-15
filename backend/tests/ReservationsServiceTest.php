<?php

use PHPUnit\Framework\TestCase;

// Need to require these files since there's no namespace-based autoloading
require_once __DIR__ . '/../rest/services/ReservationsService.class.php';
require_once __DIR__ . '/../rest/dao/ReservationsDao.class.php';

class ReservationsServiceTest extends TestCase
{
    private $mockReservationsDao;
    private $reservationsService;

    protected function setUp(): void
    {
        // Create mock objects
        $this->mockReservationsDao = $this->createMock(ReservationsDao::class);
        
        // Create the service with mock DAO
        $this->reservationsService = new ReservationsService();
        
        // Use reflection to set private property
        $reflectionProperty = new ReflectionProperty(ReservationsService::class, 'reservationsDao');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->reservationsService, $this->mockReservationsDao);
    }

    public function testGetReservationsByUserId()
    {
        // Arrange
        $userId = 1;
        $expectedReservations = [
            [
                'id' => 1,
                'user_id' => $userId,
                'shop_id' => 2,
                'reservation_date' => '2023-11-15',
                'reservation_time' => '14:00:00',
                'number_of_people' => 2,
                'status' => 'confirmed',
                'shop_name' => 'Pastry Shop 2'
            ],
            [
                'id' => 3,
                'user_id' => $userId,
                'shop_id' => 4,
                'reservation_date' => '2023-11-18',
                'reservation_time' => '16:00:00',
                'number_of_people' => 4,
                'status' => 'pending',
                'shop_name' => 'Pastry Shop 4'
            ]
        ];
        
        // Set up the mock to return reservations when get_user_reservations is called
        $this->mockReservationsDao->expects($this->once())
            ->method('get_user_reservations')
            ->with($userId)
            ->willReturn($expectedReservations);
        
        // Act
        $result = $this->reservationsService->get_user_reservations($userId);
        
        // Assert
        $this->assertSame($expectedReservations, $result);
        $this->assertCount(2, $result);
    }

    public function testAddReservation()
    {
        // Arrange
        $reservationData = [
            'user_id' => 1,
            'shop_id' => 2,
            'reservation_date' => '2023-11-20',
            'reservation_time' => '15:00:00',
            'number_of_people' => 3,
            'status' => 'pending'
        ];
        
        $expectedId = 4;
        
        // Set up the mock to return ID when add_reservation is called
        $this->mockReservationsDao->expects($this->once())
            ->method('add_reservation')
            ->with($reservationData)
            ->willReturn($expectedId);
        
        // Act
        $result = $this->reservationsService->add_reservation($reservationData);
        
        // Assert
        $this->assertEquals($expectedId, $result);
    }

    public function testUpdateReservationStatus()
    {
        // Arrange
        $reservationId = 1;
        $newStatus = 'confirmed';
        
        // Set up the mock to return true when update_reservation_status is called
        $this->mockReservationsDao->expects($this->once())
            ->method('update_reservation_status')
            ->with($reservationId, $newStatus)
            ->willReturn(true);
        
        // Act
        $result = $this->reservationsService->update_reservation_status($reservationId, $newStatus);
        
        // Assert
        $this->assertTrue($result);
    }

    public function testGetReservationsByShopId()
    {
        // Arrange
        $shopId = 2;
        $expectedReservations = [
            [
                'id' => 1,
                'user_id' => 1,
                'shop_id' => $shopId,
                'reservation_date' => '2023-11-15',
                'reservation_time' => '14:00:00',
                'number_of_people' => 2,
                'status' => 'confirmed',
                'user_name' => 'John Doe'
            ],
            [
                'id' => 5,
                'user_id' => 3,
                'shop_id' => $shopId,
                'reservation_date' => '2023-11-22',
                'reservation_time' => '10:00:00',
                'number_of_people' => 1,
                'status' => 'pending',
                'user_name' => 'Jane Smith'
            ]
        ];
        
        // Set up the mock to return reservations when get_shop_reservations is called
        $this->mockReservationsDao->expects($this->once())
            ->method('get_shop_reservations')
            ->with($shopId)
            ->willReturn($expectedReservations);
        
        // Act
        $result = $this->reservationsService->get_shop_reservations($shopId);
        
        // Assert
        $this->assertSame($expectedReservations, $result);
        $this->assertCount(2, $result);
    }
}
