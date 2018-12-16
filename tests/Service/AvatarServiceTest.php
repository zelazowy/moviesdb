<?php declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\AvatarService;
use PHPUnit\Framework\TestCase;

class AvatarServiceTest extends TestCase
{
    public function testGetForEmail()
    {
        $avatarService = new AvatarService();

        $dd = $avatarService->getForEmail('foo@example.com');
    }
}
