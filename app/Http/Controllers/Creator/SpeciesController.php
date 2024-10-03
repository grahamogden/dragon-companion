<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Species\StoreSpeciesRequest;
use App\Http\Requests\Creator\Species\UpdateSpeciesRequest;
use App\Http\Resources\Species\SpeciesResource;
use App\Models\Campaign;
use App\Models\Species;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SpeciesController extends Controller
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
            component: 'Creator/Species/SpeciesList',
            props: [
                'species' => SpeciesResource::collection(
                    resource: $campaign->species()->paginate()
                )
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Campaign $campaign): Response
    {
        Log::debug('Create in SpeciesController');
        $this->authorize(
            ability: 'create',
            arguments: [Species::class, $campaign],
        );

        return Inertia::render(component: 'Creator/Species/SpeciesForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpeciesRequest $request, Campaign $campaign): RedirectResponse
    {
        Log::debug('Store in SpeciesController');
        $this->authorize(
            ability: 'create',
            arguments: [Species::class, $campaign],
        );

        $validated = $this->getValidatedRequestData(
            request: $request,
            appendUserId: true,
        );
        $campaign->species()->create(attributes: $validated);

        return Redirect::route(
            route: 'creator.campaigns.species.index',
            parameters: ['campaign' => $campaign->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign, Species $species): Response
    {
        $this->authorize(ability: 'view', arguments: [$species, $campaign]);

        return Inertia::render(
            component: 'Creator/Species/SpeciesView',
            props: ['species' => $species]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign, Species $species): Response
    {
        $this->authorize(ability: 'view', arguments: [$species, $campaign]);
        $this->authorize(ability: 'update', arguments: [$species, $campaign]);

        return Inertia::render(
            component: 'Creator/Species/SpeciesForm',
            props: [
                'cancelLink' => route(
                    name: 'creator.campaigns.species.show',
                    parameters: ['campaign' => $campaign, 'species' => $species]
                ),
                'species' => $species,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpeciesRequest $request, Campaign $campaign, Species $species): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: [$species, $campaign]);

        $validated = $this->getValidatedRequestData(request: $request);
        $species->update(attributes: $validated);

        return Redirect::route(route: 'creator.campaigns.species.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Species $species): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: [$species, $campaign]);

        $species->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.species.index', parameters: ['campaign' => $campaign->id]);
    }
}
