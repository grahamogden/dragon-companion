<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Item\StoreItemRequest;
use App\Http\Requests\Creator\Item\UpdateItemRequest;
use App\Models\Campaign;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Campaign $campaign): Response
    {
        // Ensure the user is allowed to view this campaign
        $this->authorize(
            ability: 'view',
            arguments: $campaign
        );
        $this->authorize(
            ability: 'viewAny',
            arguments: Item::class
        );

        return Inertia::render(
            component: 'Creator/Items/ItemList',
            props: [
                'items' => $campaign->items()
                    ->paginate()
                    ->map(callback: function (Item $item) use ($campaign): array {
                        return [
                            ...$item->toArray(),
                            'edit_url' => $this->generateEditLinkForEntityInCampaign(
                                campaign: $campaign,
                                model: $item,
                                modelName: 'item',
                                modelRouteName: 'items',
                            ),
                            'view_url' => $this->generateShowLinkForEntityInCampaign(
                                campaign: $campaign,
                                model: $item,
                                modelName: 'item',
                                modelRouteName: 'items',
                            ),
                            'delete_url' => $this->generateDestroyLinkForEntityInCampaign(
                                campaign: $campaign,
                                model: $item,
                                modelName: 'item',
                                modelRouteName: 'items',
                            ),
                        ];
                    })
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        $this->authorize(
            ability: 'create',
            arguments: Item::class
        );

        return Inertia::render(component: 'Creator/Items/ItemForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request, Campaign $campaign): RedirectResponse
    {
        $this->authorize(
            ability: 'create',
            arguments: Item::class
        );

        $validated = $this->getValidatedRequestData(
            request: $request,
            appendUserId: true,
        );
        $campaign->items()->create(attributes: $validated);

        return Redirect::route(
            route: 'creator.campaigns.items.index',
            parameters: ['campaign' => $campaign->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign, Item $item): Response
    {
        $this->authorize(ability: 'view', arguments: $item);

        return Inertia::render(
            component: 'Creator/Items/ItemView',
            props: ['item' => $item]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign, Item $item): Response
    {
        $this->authorize(ability: 'view', arguments: $item);
        $this->authorize(ability: 'update ', arguments: $item);

        return Inertia::render(
            component: 'Creator/Items/ItemForm',
            props: ['item' => $item]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Campaign $campaign, Item $item): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: $item);

        $validated = $this->getValidatedRequestData(request: $request);
        $item->update(attributes: $validated);

        return Redirect::route(route: 'creator.campaigns.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Item $item): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: $item);

        $item->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.items.index', parameters: ['campaign' => $campaign->id]);
    }
}
