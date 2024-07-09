<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Model\Enum;

use App\Model\Enum\RolePermission;
use PHPUnit\Framework\TestCase;

class RolePermissionTest extends TestCase
{
    /*
     * label tests
     */

    public static function dataProviderForLabelWillReturnCorrectValuesTests(): array
    {
        return [
            'Read only' => [
                'permissions' => RolePermission::Read,
                'label' => 'Read',
            ],
            'Read + write' => [
                'permissions' => RolePermission::Read_write,
                'label' => 'Read Write',
            ],
            'Read + delete' => [
                'permissions' => RolePermission::Read_delete,
                'label' => 'Read Delete',
            ],
            'Read + write + delete' => [
                'permissions' => RolePermission::Read_write_delete,
                'label' => 'Read Write Delete',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForLabelWillReturnCorrectValuesTests
     */

    public function testLabelWillReturnCorrectValues(RolePermission $permission, string $label): void
    {
        $this->assertSame(expected: $label, actual: $permission->label());
    }

    /*
     * hasReadPermission tests
     */

    public static function dataProviderForHasReadPermissionTrueTests(): array
    {
        return [
            'Read only' => [
                'permissions' => RolePermission::Read,
                'permissionsValue' => 2,
            ],
            'Read + write' => [
                'permissions' => RolePermission::Read_write,
                'permissionsValue' => 6,
            ],
            'Read + delete' => [
                'permissions' => RolePermission::Read_delete,
                'permissionsValue' => 10,
            ],
            'Read + write + delete' => [
                'permissions' => RolePermission::Read_write_delete,
                'permissionsValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasReadPermissionTrueTests
     */
    public function testHasReadPermissionWillReturnTrueForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasReadPermission($permissions);
        $resultForPermissionValue = RolePermission::hasReadPermissionForValue($permissionsValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasReadPermissionFalseTests(): array
    {
        return [
            'Inherit' => [
                'permissions' => RolePermission::Inherit,
                'permissionsValue' => 1,
            ],
            'Write only' => [
                'permissions' => RolePermission::Write,
                'permissionsValue' => 4,
            ],
            'Delete only' => [
                'permissions' => RolePermission::Delete,
                'permissionsValue' => 8,
            ],
            'Write + delete' => [
                'permissions' => RolePermission::Write_delete,
                'permissionsValue' => 12,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasReadPermissionFalseTests
     */
    public function testHasReadPermissionWillReturnFalseForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasReadPermission($permissions);
        $resultForPermissionValue = RolePermission::hasReadPermissionForValue($permissionsValue);

        $this->assertFalse($resultForPermission);
        $this->assertFalse($resultForPermissionValue);
    }

    /*
     * hasWritePermission tests
     */

    public static function dataProviderForHasWritePermissionTrueTests(): array
    {
        return [
            'Write only' => [
                'permissions' => RolePermission::Write,
                'permissionsValue' => 4,
            ],
            'Read + write' => [
                'permissions' => RolePermission::Read_write,
                'permissionsValue' => 6,
            ],
            'Write + delete' => [
                'permissions' => RolePermission::Write_delete,
                'permissionsValue' => 12,
            ],
            'Read + write + delete' => [
                'permissions' => RolePermission::Read_write_delete,
                'permissionsValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasWritePermissionTrueTests
     */
    public function testHasWritePermissionWillReturnTrueForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasWritePermission($permissions);
        $resultForPermissionValue = RolePermission::hasWritePermissionForValue($permissionsValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasWritePermissionFalseTests(): array
    {
        return [
            'Read only' => [
                'permissions' => RolePermission::Read,
                'permissionsValue' => 2,
            ],
            'Delete only' => [
                'permissions' => RolePermission::Delete,
                'permissionsValue' => 8,
            ],
            'Read + delete' => [
                'permissions' => RolePermission::Read_delete,
                'permissionsValue' => 10,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasWritePermissionFalseTests
     */
    public function testHasWritePermissionWillReturnFalseForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasWritePermission($permissions);
        $resultForPermissionValue = RolePermission::hasWritePermissionForValue($permissionsValue);

        $this->assertFalse($resultForPermission);
        $this->assertFalse($resultForPermissionValue);
    }

    /*
     * hasDeletePermission tests
     */

    public static function dataProviderForHasDeletePermissionTrueTests(): array
    {
        return [
            'Delete only' => [
                'permissions' => RolePermission::Delete,
                'permissionsValue' => 8,
            ],
            'Read + delete' => [
                'permissions' => RolePermission::Read_delete,
                'permissionsValue' => 10,
            ],
            'Write + delete' => [
                'permissions' => RolePermission::Write_delete,
                'permissionsValue' => 12,
            ],
            'Read + write + delete' => [
                'permissions' => RolePermission::Read_write_delete,
                'permissionsValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasDeletePermissionTrueTests
     */
    public function testHasDeletePermissionWillReturnTrueForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasDeletePermission($permissions);
        $resultForPermissionValue = RolePermission::hasDeletePermissionForValue($permissionsValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasDeletePermissionFalseTests(): array
    {
        return [
            'Read only' => [
                'permissions' => RolePermission::Read,
                'permissionsValue' => 2,
            ],
            'Write only' => [
                'permissions' => RolePermission::Write,
                'permissionsValue' => 4,
            ],
            'Read + Write' => [
                'permissions' => RolePermission::Read_write,
                'permissionsValue' => 6,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasDeletePermissionFalseTests
     */
    public function testHasDeletePermissionWillReturnFalseForCorrectValues(RolePermission $permissions, int $permissionsValue): void
    {
        $resultForPermission = RolePermission::hasDeletePermission($permissions);
        $resultForPermissionValue = RolePermission::hasDeletePermissionForValue($permissionsValue);

        $this->assertFalse($resultForPermission);
        $this->assertFalse($resultForPermissionValue);
    }
}
