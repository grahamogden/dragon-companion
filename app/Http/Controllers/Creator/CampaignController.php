<?php

namespace App\Http\Controllers\Creator;

use App\Enums\RolePermissionEnum;
use App\Enums\RoleLevelEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Campaign\StoreCampaignRequest;
use App\Http\Requests\Creator\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $campaigns = $this->getUser(request: $request)
            ->campaigns()
            ->paginate();

        return Inertia::render(
            component: 'Creator/Campaigns/CampaignList',
            props: ['campaigns' => $campaigns]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize(
            ability: 'create',
            arguments: Campaign::class
        );

        return Inertia::render(component: 'Creator/Campaigns/CampaignForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $this->authorize(
            ability: 'create',
            arguments: Campaign::class
        );
        $user = $this->getUser(request: $request);

        DB::transaction(callback: function () use ($request, $user): void {
            /** @var Campaign $campaign */
            $campaign = $user->campaigns()
                ->create(attributes: $request->validated());

            /** @var Role[] */
            $roles = $campaign->roles()
                ->createMany(records: [
                    [
                        Role::FIELD_NAME => 'Admin',
                        Role::FIELD_ROLE_LEVEL => RoleLevelEnum::Admin,
                    ],
                    [
                        Role::FIELD_NAME => 'Player',
                        Role::FIELD_ROLE_LEVEL => RoleLevelEnum::Player,
                    ],
                ]);

            $roles[0]->rolePermission()->create(attributes: [
                RolePermission::FIELD_CAMPAIGN_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
                RolePermission::FIELD_ITEM_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
                RolePermission::FIELD_TIMELINE_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
                RolePermission::FIELD_SPECIES_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
                RolePermission::FIELD_CHARACTER_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
                RolePermission::FIELD_MONSTER_PERMISSIONS => RolePermissionEnum::Read_or_write_or_delete,
            ]);

            $user->roles()->attach(id: $roles[0]->id);

            $roles[1]->rolePermission()->create(attributes: [
                RolePermission::FIELD_CAMPAIGN_PERMISSIONS => RolePermissionEnum::Read,
            ]);
        });

        return Redirect::route(route: 'creator.campaigns.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign): Response
    {
        $this->authorize(ability: 'view', arguments: $campaign);

        return Inertia::render(
            component: 'Creator/Campaigns/CampaignView',
            props: ['campaign' => $campaign]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign): Response
    {
        $this->authorize(ability: 'view', arguments: $campaign);
        $this->authorize(ability: 'update', arguments: $campaign);

        return Inertia::render(
            component: 'Creator/Campaigns/CampaignForm',
            props: ['campaign' => $campaign]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: $campaign);

        $campaign->update(attributes: $request->validated());

        return Redirect::route(route: 'creator.campaigns.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: $campaign);

        $campaign->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.index');
    }
}
