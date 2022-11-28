<?php
namespace Hetul\Miniproject;
use PHPUnit\Framework\TestCase;
final class UserTest extends TestCase
{
    public function testClassConstructor()
    {
        $user = new User('Hetul');
        $this->assertSame('Hetul', $user->name);
    }
    public function testisadmin()
    {
        $user = new User('admin');
        $this->assertIsString($user->isadmin());
        $this->assertSame('admin', $user->isadmin());
    }
    public function testisuser()
    {
        $user = new User('user');
        $this->assertIsString($user->isadmin());
        $this->assertSame('admin', $user->isadmin());
    }
}
