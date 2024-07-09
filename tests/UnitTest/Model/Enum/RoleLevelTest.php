<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Model\Enum;

use App\Model\Enum\RoleLevel;
use PHPUnit\Framework\TestCase;

class RoleLevelTest extends TestCase
{
    /*
     * label tests
     */

    public static function dataProviderForLabelWillReturnCorrectValuesTests(): array
    {
        return [
            'Public' => [
                'level' => RoleLevel::Public,
                'label' => 'Public',
            ],
            'Custom' => [
                'level' => RoleLevel::Custom,
                'label' => 'Custom',
            ],
            'Admin' => [
                'level' => RoleLevel::Admin,
                'label' => 'Admin',
            ],
            'Owner' => [
                'level' => RoleLevel::Owner,
                'label' => 'Owner',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForLabelWillReturnCorrectValuesTests
     */

    public function testLabelWillReturnCorrectValues(RoleLevel $level, string $label): void
    {
        $this->assertSame(expected: $label, actual: $level->label());
    }
}
