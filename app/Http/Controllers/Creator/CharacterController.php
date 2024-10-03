<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Character\StoreCharacterRequest;
use App\Http\Requests\Creator\Character\UpdateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\Species\SpeciesOptionResource;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Species;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CharacterController extends Controller
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
            component: 'Creator/Characters/CharacterList',
            props: [
                'characters' => CharacterResource::collection(resource: $campaign->characters()
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
            arguments: [Character::class, $campaign]
        );

        return Inertia::render(component: 'Creator/Characters/CharacterForm', props: [
            'species' => SpeciesOptionResource::collection(resource: $campaign->species()->getModels()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacterRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(
            ability: 'create',
            arguments: [Character::class, $campaign]
        );

        $validated = $this->getValidatedRequestData(
            request: $request,
            appendUserId: true,
        );
        $campaign->characters()->create(attributes: $validated);

        return Redirect::route(
            route: 'creator.campaigns.characters.index',
            parameters: ['campaign' => $campaign->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign, Character $character): Response
    {
        $this->authorize(ability: 'view', arguments: [$character, $campaign]);
        $character->load(relations: [Species::TABLE_NAME]);

        return Inertia::render(
            component: 'Creator/Characters/CharacterView',
            props: [
                'character' => $character,
            ],
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign, Character $character): Response
    {
        $this->authorize(ability: 'view', arguments: [$character, $campaign]);
        $this->authorize(ability: 'update', arguments: [$character, $campaign]);

        return Inertia::render(
            component: 'Creator/Characters/CharacterForm',
            props: [
                'character' => $character,
                'species' => SpeciesOptionResource::collection(resource: $campaign->species()->getModels()),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCharacterRequest $request, Campaign $campaign, Character $character): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: [$character, $campaign]);

        $validated = $this->getValidatedRequestData(request: $request);
        $character->update(attributes: $validated);

        return Redirect::route(route: 'creator.campaigns.characters.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Character $character): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: [$character, $campaign]);

        $character->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.characters.index', parameters: ['campaign' => $campaign->id]);
    }
}
