<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
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
        $campaigns = $this->getUser($request)->campaigns()->paginate();
        return Inertia::render('Creator/Campaigns/CampaignList', ['campaigns' => $campaigns]);
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
    public function store(StoreCampaignRequest $request)
    {
        // $validated = $request->validate([
        //     Campaign::FIELD_NAME => 'required|string|max:255',
        //     Campaign::FIELD_SYNOPSIS => 'required|string',
        // ]);

        // $campaign = Campaign::create([
        //     Campaign::FIELD_NAME => $request->name,
        //     Campaign::FIELD_SYNOPSIS => $request->synopsis,
        // ]);
        $request->user()->campaigns()->create($request->validated());

        return redirect(route('creator.campaigns.index', absolute: false));
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
        return Inertia::render('Campaigns/Edit', [
            'status' => session('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
