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
                'permission' => RolePermission::Read,
                'label' => 'Read',
            ],
            'Read + write' => [
                'permission' => RolePermission::Read_write,
                'label' => 'Read Write',
            ],
            'Read + delete' => [
                'permission' => RolePermission::Read_delete,
                'label' => 'Read Delete',
            ],
            'Read + write + delete' => [
                'permission' => RolePermission::Read_write_delete,
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
                'permission' => RolePermission::Read,
                'permissionValue' => 2,
            ],
            'Read + write' => [
                'permission' => RolePermission::Read_write,
                'permissionValue' => 6,
            ],
            'Read + delete' => [
                'permission' => RolePermission::Read_delete,
                'permissionValue' => 10,
            ],
            'Read + write + delete' => [
                'permission' => RolePermission::Read_write_delete,
                'permissionValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasReadPermissionTrueTests
     */
    public function testHasReadPermissionWillReturnTrueForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasReadPermission($permission);
        $resultForPermissionValue = RolePermission::hasReadPermissionForValue($permissionValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasReadPermissionFalseTests(): array
    {
        return [
            'Inherit' => [
                'permission' => RolePermission::Inherit,
                'permissionValue' => 1,
            ],
            'Write only' => [
                'permission' => RolePermission::Write,
                'permissionValue' => 4,
            ],
            'Delete only' => [
                'permission' => RolePermission::Delete,
                'permissionValue' => 8,
            ],
            'Write + delete' => [
                'permission' => RolePermission::Write_delete,
                'permissionValue' => 12,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasReadPermissionFalseTests
     */
    public function testHasReadPermissionWillReturnFalseForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasReadPermission($permission);
        $resultForPermissionValue = RolePermission::hasReadPermissionForValue($permissionValue);

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
                'permission' => RolePermission::Write,
                'permissionValue' => 4,
            ],
            'Read + write' => [
                'permission' => RolePermission::Read_write,
                'permissionValue' => 6,
            ],
            'Write + delete' => [
                'permission' => RolePermission::Write_delete,
                'permissionValue' => 12,
            ],
            'Read + write + delete' => [
                'permission' => RolePermission::Read_write_delete,
                'permissionValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasWritePermissionTrueTests
     */
    public function testHasWritePermissionWillReturnTrueForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasWritePermission($permission);
        $resultForPermissionValue = RolePermission::hasWritePermissionForValue($permissionValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasWritePermissionFalseTests(): array
    {
        return [
            'Read only' => [
                'permission' => RolePermission::Read,
                'permissionValue' => 2,
            ],
            'Delete only' => [
                'permission' => RolePermission::Delete,
                'permissionValue' => 8,
            ],
            'Read + delete' => [
                'permission' => RolePermission::Read_delete,
                'permissionValue' => 10,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasWritePermissionFalseTests
     */
    public function testHasWritePermissionWillReturnFalseForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasWritePermission($permission);
        $resultForPermissionValue = RolePermission::hasWritePermissionForValue($permissionValue);

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
                'permission' => RolePermission::Delete,
                'permissionValue' => 8,
            ],
            'Read + delete' => [
                'permission' => RolePermission::Read_delete,
                'permissionValue' => 10,
            ],
            'Write + delete' => [
                'permission' => RolePermission::Write_delete,
                'permissionValue' => 12,
            ],
            'Read + write + delete' => [
                'permission' => RolePermission::Read_write_delete,
                'permissionValue' => 14,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasDeletePermissionTrueTests
     */
    public function testHasDeletePermissionWillReturnTrueForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasDeletePermission($permission);
        $resultForPermissionValue = RolePermission::hasDeletePermissionForValue($permissionValue);

        $this->assertTrue($resultForPermission);
        $this->assertTrue($resultForPermissionValue);
    }

    public static function dataProviderForHasDeletePermissionFalseTests(): array
    {
        return [
            'Read only' => [
                'permission' => RolePermission::Read,
                'permissionValue' => 2,
            ],
            'Write only' => [
                'permission' => RolePermission::Write,
                'permissionValue' => 4,
            ],
            'Read + Write' => [
                'permission' => RolePermission::Read_write,
                'permissionValue' => 6,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForHasDeletePermissionFalseTests
     */
    public function testHasDeletePermissionWillReturnFalseForCorrectValues(RolePermission $permission, int $permissionValue): void
    {
        $resultForPermission = RolePermission::hasDeletePermission($permission);
        $resultForPermissionValue = RolePermission::hasDeletePermissionForValue($permissionValue);

        $this->assertFalse($resultForPermission);
        $this->assertFalse($resultForPermissionValue);
    }
}
