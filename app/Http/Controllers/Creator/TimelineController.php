<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Creator\Timeline\StoreTimelineRequest;
use App\Http\Requests\Creator\Timeline\UpdateTimelineRequest;
use App\Models\Campaign;
use App\Models\Timeline;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TimelineController extends Controller
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
            component: 'Creator/Timelines/TimelineList',
            props: [
                'timelines' => $campaign->timelines()
                    ->whereNull(columns: Timeline::FIELD_PARENT_ID)
                    ->paginate()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Campaign $campaign): Response
    {
        Log::debug('Create in TimelineController');
        $this->authorize(
            ability: 'create',
            arguments: [Timeline::class, $campaign],
        );

        $props = [];

        $parentId = $request->query(key: Timeline::FIELD_PARENT_ID);
        if ($parentId && is_numeric($parentId)) {
            Log::debug('Parent ID: ' . $parentId);
            $parentTimeline = $campaign->timelines()
                ->whereKey(id: (int) $parentId)
                ->firstOrFail();

            $props['parent'] = $parentTimeline;
            $props['cancelLink'] = $parentTimeline
                ? route(name: 'creator.campaigns.timelines.show', parameters: ['campaign' => $campaign, 'timeline' => $parentTimeline])
                : route(name: 'creator.campaigns.timelines.index', parameters: ['campaign' => $campaign]);
        }

        return Inertia::render(component: 'Creator/Timelines/TimelineForm', props: $props);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelineRequest $request, Campaign $campaign): RedirectResponse
    {
        Log::debug('Store in TimelineController');
        $this->authorize(
            ability: 'create',
            arguments: [Timeline::class, $campaign],
        );

        $validated = $this->getValidatedRequestData(
            request: $request,
            appendUserId: true,
        );
        $timeline = $campaign->timelines()->create(attributes: $validated);

        if ($timeline->parent_id) {
            return Redirect::route(
                route: 'creator.campaigns.timelines.show',
                parameters: ['campaign' => $campaign->id, 'timeline' => $timeline->parent_id]
            );
        } else {
            return Redirect::route(
                route: 'creator.campaigns.timelines.index',
                parameters: ['campaign' => $campaign->id]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Campaign $campaign, Timeline $timeline): Response
    {
        $this->authorize(ability: 'view', arguments: [$timeline, $campaign]);
        $timeline->load(relations: ['children', 'parent']);
        Log::debug(var_export($timeline, true));

        return Inertia::render(
            component: 'Creator/Timelines/TimelineView',
            props: ['timeline' => $timeline]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Campaign $campaign, Timeline $timeline): Response
    {
        $this->authorize(ability: 'view', arguments: [$timeline, $campaign]);
        $this->authorize(ability: 'update', arguments: [$timeline, $campaign]);

        return Inertia::render(
            component: 'Creator/Timelines/TimelineForm',
            props: [
                'cancelLink' => route('creator.campaigns.timelines.show', ['campaign' => $campaign, 'timeline' => $timeline]),
                'timeline' => $timeline,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimelineRequest $request, Campaign $campaign, Timeline $timeline): RedirectResponse
    {
        $this->authorize(ability: 'update', arguments: [$timeline, $campaign]);

        $validated = $this->getValidatedRequestData(request: $request);
        $timeline->update(attributes: $validated);

        return Redirect::route(route: 'creator.campaigns.timelines.index', parameters: ['campaign' => $campaign->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Campaign $campaign, Timeline $timeline): RedirectResponse
    {
        $this->authorize(ability: 'delete', arguments: [$timeline, $campaign]);

        $timeline->deleteOrFail();

        return Redirect::route(route: 'creator.campaigns.timelines.index', parameters: ['campaign' => $campaign->id]);
    }
}
