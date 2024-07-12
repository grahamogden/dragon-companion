<?php

declare(strict_types=1);

namespace App\Test\UnitTest\Policy;

use App\Model\Entity\Interface\CampaignChildEntityInterface;
use App\Model\Entity\Interface\PermissionInterface;
use App\Model\Entity\Role;
use App\Model\Entity\User;
use App\Model\Enum\RoleLevel;
use App\Model\Enum\RolePermission;
use App\Policy\StandardPolicyTrait;
use Cake\ORM\Entity;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class StandardPolicyTraitTest extends TestCase
{
    public const TEST_CAMPAIGN_ID = 7;

    /*********************************
     * getOverridePermissionsTableName tests *
     *********************************/

    public function testGetOverridePermissionsTableNameWillThrowRuntimeExceptionIfPermissionsTableNameIsNotSet(): void
    {
        $objectUnderTest = new DummyStandardPolicyTraitWithoutPermissions();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('overridePermissionsTableName was not set on policy');

        $objectUnderTest->getOverridePermissionsTableNameWrapper();
    }

    public function testGetOverridePermissionsTableNameWillReturnPermissionsTableNameIfItIsSet(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();

        $result = $objectUnderTest->getOverridePermissionsTableNameWrapper();

        $this->assertSame('overridePermissionsTableName', $result);
    }

    /****************************************
     * getDefaultPermissionsFieldName tests *
     ****************************************/

    public function testGetDefaultPermissionsFieldNameWillThrowRuntimeExceptionIfDefaultPermissionsFieldNameIsNotSet(): void
    {
        $objectUnderTest = new DummyStandardPolicyTraitWithoutPermissions();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('defaultPermissionsFieldName was not set on policy');

        $objectUnderTest->getDefaultPermissionsFieldNameWrapper();
    }

    public function testGetDefaultPermissionsFieldNameWillReturnDefaultPermissionsFieldNameIfItIsSet(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();

        $result = $objectUnderTest->getDefaultPermissionsFieldNameWrapper();

        $this->assertSame('getSpeciesDefaultPermissions', $result);
    }

    /***************************
     * isCampaignOwner tests *
     ***************************/

    public static function dataProviderForIsCampaignOwnerWillThrowRuntimeExceptionIfDefaultPermissionsFieldNameIsNotSet(): array
    {
        $self = (new self(''));
        $roleWrongCampaignMock = $self->mockRole(
            campaignId: 100,
            roleLevel: RoleLevel::Owner,
        );
        $roleWrongRoleTypeMock = $self->mockRole(
            campaignId: self::TEST_CAMPAIGN_ID,
            roleLevel: RoleLevel::Admin,
        );
        $roleCorrectMock = $self->mockRole(
            campaignId: self::TEST_CAMPAIGN_ID,
            roleLevel: RoleLevel::Owner,
        );

        return [
            'No roles found returns false' => [
                'roles' => [],
                'expected' => false,
            ],
            'Roles with incorrect campaign ID returns false' => [
                'roles' => [
                    $roleWrongCampaignMock,
                ],
                'expected' => false,
            ],
            'Roles with role level = admin returns false' => [
                'roles' => [
                    $roleWrongRoleTypeMock,
                ],
                'expected' => false,
            ],
            'Correct campaign and correct role returns true' => [
                'roles' => [
                    $roleCorrectMock,
                ],
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForIsCampaignOwnerWillThrowRuntimeExceptionIfDefaultPermissionsFieldNameIsNotSet
     */

    public function testIsCampaignOwnerWillReturnCorrectResultIfUserIsTheOwnerOfCampaign(array $roles, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();

        $result = $objectUnderTest->isCampaignOwnerWrapper(
            $this->mockIdentityInterfaceUser($roles),
            self::TEST_CAMPAIGN_ID,
        );

        $this->assertSame($expected, $result);
    }

    /************************************************
     * getOverrideEntityRolePermissionForUser tests *
     ************************************************/

    public static function dataProviderForGetOverrideEntityRolePermissionForUserReturnsInheritIfNoEntityPermissionsAvailable(): array
    {
        $self = (new self(''));
        $rolePermission = RolePermission::Read_write_delete;

        return [
            'No entity permissions available' => [
                'entityPermissions' => [],
            ],
            'Entity permission with wrong role ID' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        roleId: 15,
                        permissions: $rolePermission,
                    ),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForGetOverrideEntityRolePermissionForUserReturnsInheritIfNoEntityPermissionsAvailable
     */

    public function testGetOverrideEntityRolePermissionForUserReturnsInheritIfEntityPermissionsNotFound(array $entityPermissions): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();

        $result = $objectUnderTest->getOverrideEntityRolePermissionForUserWrapper(
            role: $this->mockRole(roleId: 1),
            entity: $this->mockEntity(
                entityPermissions: $entityPermissions,
            ),
        );

        $this->assertSame(RolePermission::Inherit, $result);
    }

    public static function dataProviderForGetOverrideEntityRolePermissionForUserReturnsRolePermissionIfRoleIdsMatch(): array
    {
        return [
            'Inherit' => [
                'rolePermission' => RolePermission::Inherit,
            ],
            'Read' => [
                'rolePermission' => RolePermission::Read,
            ],
            'Write + Delete' => [
                'rolePermission' => RolePermission::Write_delete,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForGetOverrideEntityRolePermissionForUserReturnsRolePermissionIfRoleIdsMatch
     */

    public function testGetOverrideEntityRolePermissionForUserReturnsRolePermissionIfRoleIdsMatch(RolePermission $rolePermission): void
    {
        $roleId = 15;

        $objectUnderTest = new DummyStandardPolicyTrait();

        $entityPermission = $this->mockEntityPermission(
            roleId: $roleId,
            permissions: $rolePermission,
        );

        $result = $objectUnderTest->getOverrideEntityRolePermissionForUserWrapper(
            role: $this->mockRole(roleId: $roleId),
            entity: $this->mockEntity(
                entityPermissions: [
                    $entityPermission
                ],
            ),
        );

        $this->assertSame($rolePermission, $result);
    }

    /*****************
     * canAdd tests *
     *****************/

    public static function dataProviderForCanAddReturnsFalseIfUserRoleNotFoundForCampaign(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'No roles found' => [
                'roles' => [],
            ],
            'Roles without correct campaign ID' => [
                'roles' => [
                    $roleMock,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanAddReturnsFalseIfUserRoleNotFoundForCampaign
     */
    public function testCanAddReturnsFalseIfUserDoesNotHavePermissionForCampaign(array $roles): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canAdd(
            $this->mockIdentityInterfaceUser($roles),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public function testCanAddReturnsFalseIfPermissionsFieldNameIsNotCallable(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $objectUnderTest->defaultPermissionsFieldName = 'doesNotExist';

        $result = $objectUnderTest->canAdd(
            $this->mockIdentityInterfaceUser([
                $this->mockRole()
            ]),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public static function dataProviderForCanAddReturnsFalseIfUserDoesNotHaveWritePermissionForPermissionField(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'Deny returns false' => [
                'rolePermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'Write returns true' => [
                'rolePermission' => RolePermission::Write,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanAddReturnsFalseIfUserDoesNotHaveWritePermissionForPermissionField
     */
    public function testCanAddReturnsBoolIfUserHasWritePermissionForDefaultPermissionFieldOrNot(RolePermission $rolePermission, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();

        $result = $objectUnderTest->canAdd(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    speciesPermissionRolePermission: $rolePermission,
                )
            ]),
            $this->mockEntity(),
        );

        $this->assertSame(expected: $expected, actual: $result);
    }

    /*****************
     * canView tests *
     *****************/

    public static function dataProviderForCanViewReturnsFalseIfUserRoleNotFoundForCampaign(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'No roles found' => [
                'roles' => [],
            ],
            'Roles without correct campaign ID' => [
                'roles' => [
                    $roleMock,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanViewReturnsFalseIfUserRoleNotFoundForCampaign
     */
    public function testCanViewReturnsFalseIfUserDoesNotHavePermissionForCampaign(array $roles): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser($roles),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public function testCanViewReturnsFalseIfPermissionsFieldNameIsNotCallable(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $objectUnderTest->defaultPermissionsFieldName = 'doesNotExist';

        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser([
                $this->mockRole()
            ]),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public static function dataProviderForCanViewReturnsWhetherUserHasReadPermissionForDefaultPermissionField(): array
    {
        $self = (new self(''));

        return [
            'No entity permissions found + default is "Deny"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'Entity permission has "inherit" + default is "Deny"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'No entity permissions found + default is "Read"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Read,
                'expected' => true,
            ],
            'Entity permission has "inherit" + default is "Read"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Read,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanViewReturnsWhetherUserHasReadPermissionForDefaultPermissionField
     *
     * If there are no override permissions, then check that canView will return false if the user
     * does not have read permission for the default permission field
     */
    public function testCanViewReturnsWhetherUserHasReadPermissionForDefaultPermissionField(array $entityPermissions, RolePermission $defaultPermission, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    speciesPermissionRolePermission: $defaultPermission,
                )
            ]),
            $this->mockEntity(entityPermissions: $entityPermissions),
        );

        $this->assertSame($expected, $result);
    }

    public function testCanViewReturnsTrueIfUserRoleHasReadOverridePermission(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Read
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    /**
     * Tests that even if the user has permissions set to deny, that they will always be
     * authorized to view the entity if they own the campaign
     */
    public function testCanViewReturnsTrueIfUserRoleIsOwner(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                    roleLevel: RoleLevel::Owner
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Deny
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    public static function dataProviderForCanViewReturnsFalseIfUserRoleHasOverridePermissionExcludingRead(): array
    {
        $self = (new self(''));

        return [
            'Deny' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Deny,
                )],
            ],
            'Write' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Write,
                )],
            ],
            'Write + delete' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Write_delete,
                )],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanViewReturnsFalseIfUserRoleHasOverridePermissionExcludingRead
     * 
     * This test checks that we will always use whatever the override permission is, even if
     * the default says that the role does have read permission (so long as it isn't inherit)
     */
    public function testCanViewReturnsFalseIfUserRoleHasOverridePermissionExcludingRead(array $overrideRolePermission): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canView(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: $overrideRolePermission,
            ),
        );

        $this->assertFalse($result);
    }

    /******************
     * canIndex tests *
     ******************/

    public static function dataProviderForCanIndexReturnsFalseIfUserRoleNotFoundForCampaign(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'No roles found' => [
                'roles' => [],
            ],
            'Roles without correct campaign ID' => [
                'roles' => [
                    $roleMock,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanIndexReturnsFalseIfUserRoleNotFoundForCampaign
     */
    public function testCanIndexReturnsFalseIfUserDoesNotHavePermissionForCampaign(array $roles): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser($roles),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public function testCanIndexReturnsFalseIfPermissionsFieldNameIsNotCallable(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $objectUnderTest->defaultPermissionsFieldName = 'doesNotExist';

        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser([
                $this->mockRole()
            ]),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public static function dataProviderForCanIndexReturnsWhetherUserHasReadPermissionForDefaultPermissionField(): array
    {
        $self = (new self(''));

        return [
            'No entity permissions found + default is "Deny"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'Entity permission has "inherit" + default is "Deny"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'No entity permissions found + default is "Read"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Read,
                'expected' => true,
            ],
            'Entity permission has "inherit" + default is "Read"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Read,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanIndexReturnsWhetherUserHasReadPermissionForDefaultPermissionField
     *
     * If there are no override permissions, then check that canIndex will return false if the user
     * does not have read permission for the default permission field
     */
    public function testCanIndexReturnsWhetherUserHasReadPermissionForDefaultPermissionField(array $entityPermissions, RolePermission $defaultPermission, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    speciesPermissionRolePermission: $defaultPermission,
                )
            ]),
            $this->mockEntity(entityPermissions: $entityPermissions),
        );

        $this->assertSame($expected, $result);
    }

    public function testCanIndexReturnsTrueIfUserRoleHasReadOverridePermission(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Read,
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    /**
     * Tests that even if the user has permissions set to deny, that they will always be
     * authorized to index the entity if they own the campaign
     */
    public function testCanIndexReturnsTrueIfUserRoleIsOwner(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                    roleLevel: RoleLevel::Owner
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Deny
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    public static function dataProviderForCanIndexReturnsFalseIfUserRoleHasOverridePermissionExcludingRead(): array
    {
        $self = (new self(''));

        return [
            'Deny' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Deny,
                )],
            ],
            'Write' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Write,
                )],
            ],
            'Write + delete' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Write_delete,
                )],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanIndexReturnsFalseIfUserRoleHasOverridePermissionExcludingRead
     * 
     * This test checks that we will always use whatever the override permission is, even if
     * the default says that the role does have read permission (so long as it isn't inherit)
     */
    public function testCanIndexReturnsFalseIfUserRoleHasOverridePermissionExcludingRead(array $overrideRolePermission): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canIndex(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: $overrideRolePermission,
            ),
        );

        $this->assertFalse($result);
    }

    /*****************
     * canEdit tests *
     *****************/

    public static function dataProviderForCanEditReturnsFalseIfUserRoleNotFoundForCampaign(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'No roles found' => [
                'roles' => [],
            ],
            'Roles without correct campaign ID' => [
                'roles' => [
                    $roleMock,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanEditReturnsFalseIfUserRoleNotFoundForCampaign
     */
    public function testCanEditReturnsFalseIfUserDoesNotHavePermissionForCampaign(array $roles): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser($roles),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public function testCanEditReturnsFalseIfPermissionsFieldNameIsNotCallable(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $objectUnderTest->defaultPermissionsFieldName = 'doesNotExist';

        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser([
                $this->mockRole()
            ]),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public static function dataProviderForCanEditReturnsWhetherUserHasWritePermissionForDefaultPermissionField(): array
    {
        $self = (new self(''));

        return [
            'No entity permissions found + default is "Deny"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'Entity permission has "inherit" + default is "Deny"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'No entity permissions found + default is "Write"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Write,
                'expected' => true,
            ],
            'Entity permission has "inherit" + default is "Write"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Write,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanEditReturnsWhetherUserHasWritePermissionForDefaultPermissionField
     *
     * If there are no override permissions, then check that canEdit will return false if the user
     * does not have write permission for the default permission field
     */
    public function testCanEditReturnsWhetherUserHasWritePermissionForDefaultPermissionField(array $entityPermissions, RolePermission $defaultPermission, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    speciesPermissionRolePermission: $defaultPermission,
                )
            ]),
            $this->mockEntity(entityPermissions: $entityPermissions),
        );

        $this->assertSame($expected, $result);
    }

    public function testCanEditReturnsTrueIfUserRoleHasWriteOverridePermission(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Write,
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    /**
     * Tests that even if the user has permissions set to deny, that they will always be
     * authorized to edit the entity if they own the campaign
     */
    public function testCanEditReturnsTrueIfUserRoleIsOwner(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                    roleLevel: RoleLevel::Owner
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Deny
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    public static function dataProviderForCanEditReturnsFalseIfUserRoleHasOverridePermissionExcludingWrite(): array
    {
        $self = (new self(''));

        return [
            'Deny' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Deny,
                )],
            ],
            'Read' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Read,
                )],
            ],
            'Read + delete' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Read_delete,
                )],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanEditReturnsFalseIfUserRoleHasOverridePermissionExcludingWrite
     * 
     * This test checks that we will always use whatever the override permission is, even if
     * the default says that the role does have write permission (so long as it isn't inherit)
     */
    public function testCanEditReturnsFalseIfUserRoleHasOverridePermissionExcludingWrite(array $overrideRolePermission): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canEdit(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: $overrideRolePermission,
            ),
        );

        $this->assertFalse($result);
    }

    /******************
     * canDelete tests *
     ******************/

    public static function dataProviderForCanDeleteReturnsFalseIfUserRoleNotFoundForCampaign(): array
    {
        $roleMock = (new self(''))->mockRole(
            campaignId: 100,
        );

        return [
            'No roles found' => [
                'roles' => [],
            ],
            'Roles without correct campaign ID' => [
                'roles' => [
                    $roleMock,
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanDeleteReturnsFalseIfUserRoleNotFoundForCampaign
     */
    public function testCanDeleteReturnsFalseIfUserDoesNotHavePermissionForCampaign(array $roles): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser($roles),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public function testCanDeleteReturnsFalseIfPermissionsFieldNameIsNotCallable(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $objectUnderTest->defaultPermissionsFieldName = 'doesNotExist';

        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser([
                $this->mockRole()
            ]),
            $this->mockEntity(),
        );

        $this->assertFalse($result);
    }

    public static function dataProviderForCanDeleteReturnsWhetherUserHasDeletePermissionForDefaultPermissionField(): array
    {
        $self = (new self(''));

        return [
            'No entity permissions found + default is "Deny"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'Entity permission has "inherit" + default is "Deny"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Deny,
                'expected' => false,
            ],
            'No entity permissions found + default is "Delete"' => [
                'entityPermissions' => [],
                'defaultPermission' => RolePermission::Delete,
                'expected' => true,
            ],
            'Entity permission has "inherit" + default is "Delete"' => [
                'entityPermissions' => [
                    $self->mockEntityPermission(
                        permissions: RolePermission::Inherit,
                    ),
                ],
                'defaultPermission' => RolePermission::Delete,
                'expected' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanDeleteReturnsWhetherUserHasDeletePermissionForDefaultPermissionField
     *
     * If there are no override permissions, then check that canDelete will return false if the user
     * does not have delete permission for the default permission field
     */
    public function testCanDeleteReturnsWhetherUserHasDeletePermissionForDefaultPermissionField(array $entityPermissions, RolePermission $defaultPermission, bool $expected): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    speciesPermissionRolePermission: $defaultPermission,
                )
            ]),
            $this->mockEntity(entityPermissions: $entityPermissions),
        );

        $this->assertSame($expected, $result);
    }

    public function testCanDeleteReturnsTrueIfUserRoleHasDeleteOverridePermission(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Delete,
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    /**
     * Tests that even if the user has permissions set to deny, that they will always be
     * authorized to delete the entity if they own the campaign
     */
    public function testCanDeleteReturnsTrueIfUserRoleIsOwner(): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                    roleLevel: RoleLevel::Owner
                )
            ]),
            $this->mockEntity(
                entityPermissions: [
                    $this->mockEntityPermission(
                        roleId: 1,
                        permissions: RolePermission::Deny
                    )
                ]
            ),
        );

        $this->assertTrue($result);
    }

    public static function dataProviderForCanDeleteReturnsFalseIfUserRoleHasOverridePermissionExcludingDelete(): array
    {
        $self = (new self(''));

        return [
            'Deny' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Deny,
                )],
            ],
            'Read' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Read,
                )],
            ],
            'Read + write' => [
                'overrideRolePermission' => [$self->mockEntityPermission(
                    roleId: 1,
                    permissions: RolePermission::Read_write,
                )],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForCanDeleteReturnsFalseIfUserRoleHasOverridePermissionExcludingDelete
     * 
     * This test checks that we will always use whatever the override permission is, even if
     * the default says that the role does have delete permission (so long as it isn't inherit)
     */
    public function testCanDeleteReturnsFalseIfUserRoleHasOverridePermissionExcludingDelete(array $overrideRolePermission): void
    {
        $objectUnderTest = new DummyStandardPolicyTrait();
        $result = $objectUnderTest->canDelete(
            $this->mockIdentityInterfaceUser([
                $this->mockRole(
                    roleId: 1,
                    speciesPermissionRolePermission: RolePermission::Deny,
                )
            ]),
            $this->mockEntity(
                entityPermissions: $overrideRolePermission,
            ),
        );

        $this->assertFalse($result);
    }

    /************************
     ***** CREATE MOCKS *****
     ************************/

    /**
     * @param Role[] $roles
     */
    public function mockIdentityInterfaceUser(array $roles = []): User|MockObject
    {
        $mock = $this->createMock(User::class);
        $mock->method('getRoles')
            ->willReturn($roles);

        return $mock;
    }

    public function mockRole(
        int $campaignId = self::TEST_CAMPAIGN_ID,
        RolePermission $campaignPermissionRolePermission = RolePermission::Deny,
        RolePermission $speciesPermissionRolePermission = RolePermission::Deny,
        RoleLevel $roleLevel = RoleLevel::Admin,
        int $roleId = 1,
    ): Role|MockObject {
        $mock = $this->createMock(Role::class);
        $mock->method('getCampaignId')
            ->willReturn($campaignId);
        $mock->method('getCampaignDefaultPermissions')
            ->willReturn($campaignPermissionRolePermission);
        $mock->method('getSpeciesDefaultPermissions')
            ->willReturn($speciesPermissionRolePermission);
        $mock->method('getRoleLevel')
            ->willReturn($roleLevel);
        $mock->method('getId')
            ->willReturn($roleId);

        return $mock;
    }

    public function mockEntity(
        int $campaignId = StandardPolicyTraitTest::TEST_CAMPAIGN_ID,
        array $entityPermissions = [],
    ): CampaignChildEntityInterface|MockObject {
        $mock = $this->createMock(DummyCampaignChildEntity::class);
        $mock->method('getCampaignId')
            ->willReturn($campaignId);
        $mock->method('overridePermissionsTableName')
            ->willReturn($entityPermissions);

        return $mock;
    }

    public function mockEntityPermission(
        int $roleId = 1,
        RolePermission $permissions = RolePermission::Deny,
    ): PermissionInterface|MockObject {
        $mock = $this->createMock(DummyPermissionEntity::class);
        $mock->method('getRoleId')
            ->willReturn($roleId);
        $mock->method('getPermissions')
            ->willReturn($permissions);

        return $mock;
    }
}

/*************************
 * DUMMY CLASSES TO TEST *
 *************************/

class DummyStandardPolicyTrait
{
    public string $overridePermissionsTableName = 'overridePermissionsTableName';
    public string $defaultPermissionsFieldName = 'getSpeciesDefaultPermissions';

    use StandardPolicyTrait;

    public function getOverridePermissionsTableNameWrapper(): string
    {
        return $this->getOverridePermissionsTableName();
    }

    public function getDefaultPermissionsFieldNameWrapper(): string
    {
        return $this->getDefaultPermissionsFieldName();
    }

    public function isCampaignOwnerWrapper($identity, $campaignId): bool
    {
        return $this->isCampaignOwner(identity: $identity, campaignId: $campaignId);
    }

    public function getOverrideEntityRolePermissionForUserWrapper($role, $entity): RolePermission
    {
        return $this->getOverrideEntityRolePermissionForUser(userRole: $role, entity: $entity);
    }
}

class DummyStandardPolicyTraitWithoutPermissions
{

    public function getOverridePermissionsTableNameWrapper(): string
    {
        return $this->getOverridePermissionsTableName();
    }

    public function getDefaultPermissionsFieldNameWrapper(): string
    {
        return $this->getDefaultPermissionsFieldName();
    }

    use StandardPolicyTrait;
}

class DummyCampaignChildEntity extends Entity implements CampaignChildEntityInterface
{
    public $campaign_id = StandardPolicyTraitTest::TEST_CAMPAIGN_ID;

    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

    public function overridePermissionsTableName(): array
    {
        return [];
    }
}

class DummyPermissionEntity extends Entity implements PermissionInterface
{
    public function getRoleId(): int
    {
        return 1;
    }

    public function getPermissions(): RolePermission
    {
        return RolePermission::Deny;
    }
}
