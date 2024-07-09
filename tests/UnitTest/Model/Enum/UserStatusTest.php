<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Model\Enum;

use App\Model\Enum\RoleLevel;
use App\Model\Enum\UserStatus;
use PHPUnit\Framework\TestCase;

class UserStatusTest extends TestCase
{
    /*
     * label tests
     */

    public static function dataProviderForLabelWillReturnCorrectValuesTests(): array
    {
        return [
            'Inactive' => [
                'status' => UserStatus::Inactive,
                'label' => 'Inactive',
            ],
            'Pending' => [
                'status' => UserStatus::Pending,
                'label' => 'Pending',
            ],
            'Active' => [
                'status' => UserStatus::Active,
                'label' => 'Active',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForLabelWillReturnCorrectValuesTests
     */

    public function testLabelWillReturnCorrectValues(UserStatus $status, string $label): void
    {
        $this->assertSame(expected: $label, actual: $status->label());
    }
}
