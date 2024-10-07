<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Role\StoreRoleRequest;
use App\Http\Requests\Creator\Role\UpdateRoleRequest;
use App\Http\Resources\RolePermissionResource;
use App\Models\Campaign;
use App\Models\Role;
use App\Models\RolePermission;
use App\Services\FlashNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function __construct(private readonly FlashNotificationService $flashMessageService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Campaign $campaign): Response
    {
        $this->authorize(
            ability: 'view',
            arguments: [$campaign]
        );
        $this->authorize(
            ability: 'edit',
            arguments: [Role::class, $campaign]
        );

        $campaign->load(relations: [
            Role::TABLE_NAME . '.' . Role::RELATIONSHIP_ROLE_PERMISSION
        ]);

        return Inertia::render(
            component: 'Creator/Roles/RoleList',
            props: [
                'roles' => RolePermissionResource::collection(resource: $campaign->roles),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Campaign $campaign): Response
    {
        $this->authorize(
            ability: 'create',
            arguments: [Role::class, $campaign]
        );

        return Inertia::render(
            component: 'Creator/Roles/RoleForm',
            props: [],
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(
            ability: 'create',
            arguments: [Role::class, $campaign]
        );

        // Create Role
        $validated = $this->getValidatedRequestData(request: $request);

        $role = $campaign->roles()->create(
            attributes: [
                Role::FIELD_NAME => $validated[Role::FIELD_NAME],
                Role::FIELD_ROLE_LEVEL => $validated[Role::FIELD_ROLE_LEVEL],
            ]
        );

        // Update RolePermission
        $validatedPermission = $validated[Role::RELATIONSHIP_ROLE_PERMISSION];

        $role->rolePermission()->create(attributes: [
            RolePermission::FIELD_CAMPAIGN_PERMISSIONS => $validatedPermission[RolePermission::FIELD_CAMPAIGN_PERMISSIONS],
            RolePermission::FIELD_ITEM_PERMISSIONS => $validatedPermission[RolePermission::FIELD_ITEM_PERMISSIONS],
            RolePermission::FIELD_TIMELINE_PERMISSIONS => $validatedPermission[RolePermission::FIELD_TIMELINE_PERMISSIONS],
            RolePermission::FIELD_SPECIES_PERMISSIONS => $validatedPermission[RolePermission::FIELD_SPECIES_PERMISSIONS],
            RolePermission::FIELD_CHARACTER_PERMISSIONS => $validatedPermission[RolePermission::FIELD_CHARACTER_PERMISSIONS],
            RolePermission::FIELD_MONSTER_PERMISSIONS => $validatedPermission[RolePermission::FIELD_MONSTER_PERMISSIONS],
        ]);

        $this->flashMessageService->addSuccessMsg(
            message: "Role \"$role->name\" successfully saved"
        );

        return Redirect::route(route: 'creator.campaigns.roles.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Campaign $campaign, Role $role): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: [$role, $campaign]);

        $role->load(relations: [Role::RELATIONSHIP_ROLE_PERMISSION]);

        // Update Role
        $validated = $this->getValidatedRequestData(request: $request);

        $role->update(attributes: [
            Role::FIELD_NAME => $validated[Role::FIELD_NAME],
            Role::FIELD_ROLE_LEVEL => $validated[Role::FIELD_ROLE_LEVEL],
        ]);

        // Update RolePermission
        $validatedPermission = $validated[Role::RELATIONSHIP_ROLE_PERMISSION];

        $role->rolePermission->update(attributes: [
            RolePermission::FIELD_CAMPAIGN_PERMISSIONS => $validatedPermission[RolePermission::FIELD_CAMPAIGN_PERMISSIONS],
            RolePermission::FIELD_ITEM_PERMISSIONS => $validatedPermission[RolePermission::FIELD_ITEM_PERMISSIONS],
            RolePermission::FIELD_TIMELINE_PERMISSIONS => $validatedPermission[RolePermission::FIELD_TIMELINE_PERMISSIONS],
            RolePermission::FIELD_SPECIES_PERMISSIONS => $validatedPermission[RolePermission::FIELD_SPECIES_PERMISSIONS],
            RolePermission::FIELD_CHARACTER_PERMISSIONS => $validatedPermission[RolePermission::FIELD_CHARACTER_PERMISSIONS],
            RolePermission::FIELD_MONSTER_PERMISSIONS => $validatedPermission[RolePermission::FIELD_MONSTER_PERMISSIONS],
        ]);

        $this->flashMessageService->addSuccessMsg(
            message: "Role \"$role->name\" successfully saved"
        );
        return Redirect::route(route: 'creator.campaigns.roles.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Role $role): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: [$role, $campaign]);

        $role->deleteOrFail();

        $this->flashMessageService->addSuccessMsg(
            message: 'Role successfully deleted'
        );

        return Redirect::route(route: 'creator.campaigns.roles.index', parameters: ['campaign' => $campaign->id]);
    }
}
