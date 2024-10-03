<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Monster\StoreMonsterRequest;
use App\Http\Requests\Creator\Monster\UpdateMonsterRequest;
use App\Http\Resources\MonsterResource;
use App\Http\Resources\Species\SpeciesOptionResource;
use App\Models\Campaign;
use App\Models\Monster;
use App\Models\Species;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MonsterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Campaign $campaign): Response
    {
        // Ensure the user is allowed to view this campaign
        $this->authorize(
            ability: 'view',
            arguments: [$campaign]
        );

        return Inertia::render(
            component: 'Creator/Monsters/MonsterList',
            props: [
                'monsters' => MonsterResource::collection(resource: $campaign->monsters()
                    ->paginate())
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
            arguments: [Monster::class, $campaign]
        );

        return Inertia::render(
            component: 'Creator/Monsters/MonsterForm',
            props: [
                'species' => SpeciesOptionResource::collection(
                    resource: $campaign->species()->getModels()
                ),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonsterRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(
            ability: 'create',
            arguments: [Monster::class, $campaign]
        );

        $validated = $this->getValidatedRequestData(
            request: $request,
            appendUserId: true,
        );
        $campaign->monsters()->create(attributes: $validated);

        return Redirect::route(
            route: 'creator.campaigns.monsters.index',
            parameters: ['campaign' => $campaign->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign, Monster $monster): Response
    {
        $this->authorize(ability: 'view', arguments: [$monster, $campaign]);
        $monster->load(relations: [Species::TABLE_NAME]);

        return Inertia::render(
            component: 'Creator/Monsters/MonsterView',
            props: [
                'monster' => $monster,
            ],
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign, Monster $monster): Response
    {
        $this->authorize(ability: 'view', arguments: [$monster, $campaign]);
        $this->authorize(ability: 'update', arguments: [$monster, $campaign]);

        return Inertia::render(
            component: 'Creator/Monsters/MonsterForm',
            props: [
                'monster' => $monster,
                'species' => SpeciesOptionResource::collection(resource: $campaign->species()->getModels()),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMonsterRequest $request, Campaign $campaign, Monster $monster): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: [$monster, $campaign]);

        $validated = $this->getValidatedRequestData(request: $request);
        $monster->update(attributes: $validated);

        return Redirect::route(route: 'creator.campaigns.monsters.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Monster $monster): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: [$monster, $campaign]);

        $monster->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.monsters.index', parameters: ['campaign' => $campaign->id]);
    }
}
