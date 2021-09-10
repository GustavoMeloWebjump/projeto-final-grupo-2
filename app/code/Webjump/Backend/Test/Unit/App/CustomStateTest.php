<?php
namespace Webjump\Backend\Test\Unit\App;

use Codeception\PHPUnit\TestCase;
use Exception;
use Webjump\Backend\App\CustomState;
use Magento\Framework\Config\ScopeInterface;

class CustomStateTest extends TestCase
{

    private $configScopeMock;
    private $customState;

    protected function setUp(): void
    {
        $this->configScopeMock = $this->createMock(ScopeInterface::class);
        $this->customState = new CustomState($this->configScopeMock);
    }

    public function testValidateAreaCode () {
        try {
            $this->customState->getAreaCode();
            $this->assertEquals(true, $this->customState->validateAreaCode());
        } catch (Exception $exception) {
            $this->assertEquals(false, $this->customState->validateAreaCode());
        }
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> c4ae6c60584bb894efef1bfb4f9e705a88bd1f34
