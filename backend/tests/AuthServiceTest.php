<?php

use PHPUnit\Framework\TestCase;

// Need to require these files since there's no namespace-based autoloading
require_once __DIR__ . '/../rest/services/AuthService.class.php';
require_once __DIR__ . '/../rest/dao/AuthDao.class.php';

// Need to include config for JWT
require_once __DIR__ . '/../config_loader.php';

class AuthServiceTest extends TestCase
{
    private $mockAuthDao;
    private $authService;

    protected function setUp(): void
    {
        // Create mock objects
        $this->mockAuthDao = $this->createMock(AuthDao::class);
        
        // Create the service with mock DAO
        $this->authService = new AuthService();
        
        // Use reflection to set private property
        $reflectionProperty = new ReflectionProperty(AuthService::class, 'auth_dao');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->authService, $this->mockAuthDao);
    }

    public function testLoginWithValidCredentials()
    {
        // Arrange
        $email = "test@example.com";
        $password = "validPassword123";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $userRecord = [
            'id' => 1,
            'email' => $email,
            'password' => $hashedPassword,
            'full_name' => 'Test User',
            'role' => 'user'
        ];
        
        // Set up the mock to return a user when get_user_by_email is called
        $this->mockAuthDao->expects($this->once())
            ->method('get_user_by_email')
            ->with($email)
            ->willReturn($userRecord);
        
        // Act
        $loginData = ['email' => $email, 'password' => $password];
        $result = $this->authService->login($loginData);
        
        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('token', $result['data']);
    }

    public function testLoginWithInvalidCredentials()
    {
        // Arrange
        $email = "test@example.com";
        $password = "wrongPassword";
        $hashedPassword = password_hash("correctPassword", PASSWORD_DEFAULT);
        
        $userRecord = [
            'id' => 1,
            'email' => $email,
            'password' => $hashedPassword,
            'full_name' => 'Test User',
            'role' => 'user'
        ];
        
        // Set up the mock to return a user when get_user_by_email is called
        $this->mockAuthDao->expects($this->once())
            ->method('get_user_by_email')
            ->with($email)
            ->willReturn($userRecord);
        
        // Act
        $loginData = ['email' => $email, 'password' => $password];
        $result = $this->authService->login($loginData);
        
        // Assert
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Invalid password.', $result['error']);
    }

    public function testLoginWithNonExistentUser()
    {
        // Arrange
        $email = "nonexistent@example.com";
        $password = "anyPassword";
        
        // Set up the mock to return null when get_user_by_email is called
        $this->mockAuthDao->expects($this->once())
            ->method('get_user_by_email')
            ->with($email)
            ->willReturn(null);
        
        // Act
        $loginData = ['email' => $email, 'password' => $password];
        $result = $this->authService->login($loginData);
        
        // Assert
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Invalid email.', $result['error']);
    }
}
