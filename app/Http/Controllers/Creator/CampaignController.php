<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Campaign\StoreCampaignRequest;
use App\Http\Requests\Creator\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CampaignController extends Controller
{
    private function getUser(Request $request): User
    {
        return $request->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $campaigns = $this->getUser($request)
            ->campaigns()
            ->paginate();

        return Inertia::render(
            'Creator/Campaigns/CampaignList',
            ['campaigns' => $campaigns]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Creator/Campaigns/CampaignForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $this->getUser(request: $request)
            ->campaigns()
            ->create(attributes: $request->validated());

        return Redirect::route('creator.campaigns.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign)
    {
        return Inertia::render('Campaigns/View', [
            'status' => session('status'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign)
    {
        $this->getUser($request)
            ->can('view');

        return Inertia::render(
            'Creator/Campaigns/CampaignForm',
            ['campaign' => $campaign]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $campaign->update($request->validated());

        return Redirect::route('creator.campaigns.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign): RedirectResponse
    {
        Gate::authorize('delete', $campaign);

        $campaign->deleteOrFail();

        return Redirect::route('creator.campaigns.index');
    }
}
