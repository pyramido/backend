<?php
namespace App\Http\Controllers\Api\V1;

use App\Event;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EventResource;
use App\Http\Requests\Events\ShowRequest;
use App\Http\Requests\Events\StoreRequest;
use App\Http\Requests\Events\IndexRequest;
use App\Http\Requests\Events\DeleteRequest;
use App\Http\Requests\Events\UpdateRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventController extends Controller
{
    private const ALLOWED_FIELDS = ['title', 'date', 'description', 'contact_email'];

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return ResourceCollection
     */
    public function index(IndexRequest $request): ResourceCollection
    {
        return EventResource::collection(Event::pimp()->paginate($request->input('limit', 20)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return EventResource
     */
    public function store(StoreRequest $request): EventResource
    {
        return new EventResource(
            auth()
                ->guard('api')
                ->user()
                ->events()
                ->create(array_filter($request->only(self::ALLOWED_FIELDS)))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param $id
     * @return EventResource
     */
    public function show(ShowRequest $request, $id): EventResource
    {
        return new EventResource(Event::pimp()->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Event $event
     * @return EventResource
     */
    public function update(UpdateRequest $request, Event $event): EventResource
    {
        return new EventResource(
            tap($event)->update(array_filter($request->only(self::ALLOWED_FIELDS)))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param Event $event
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, Event $event): JsonResponse
    {
        $event->delete();
        return response()->noContent();
    }
}
