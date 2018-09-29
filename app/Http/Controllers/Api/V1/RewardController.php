<?php
namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Reward;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\RewardResource;
use App\Http\Requests\Events\Rewards\ShowRequest;
use App\Http\Requests\Events\Rewards\IndexRequest;
use App\Http\Requests\Events\Rewards\StoreRequest;
use App\Http\Requests\Events\Rewards\UpdateRequest;
use App\Http\Requests\Events\Rewards\DeleteRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @param Event $event
     * @return ResourceCollection
     */
    public function index(IndexRequest $request, Event $event): ResourceCollection
    {
        return RewardResource::collection(
            $event->rewards()->paginate($request->input('limit', 20))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RewardResource
     */
    public function store(StoreRequest $request, Event $event): RewardResource
    {
        return new RewardResource(
            $event->rewards()->create(array_filter($request->only(['title', 'description'])))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Event $event
     * @param Reward $reward
     * @return RewardResource
     */
    public function show(ShowRequest $request, Event $event, Reward $reward): RewardResource
    {
        return new RewardResource($reward);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Event $event
     * @param Reward $reward
     * @return RewardResource
     */
    public function update(UpdateRequest $request, Event $event, Reward $reward): RewardResource
    {
        return new RewardResource(
            tap($reward)->update(array_filter($request->only(['title', 'description'])))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param Event $event
     * @param Reward $reward
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, Event $event, Reward $reward): JsonResponse
    {
        $reward->delete();
        return response()->noContent();
    }
}
