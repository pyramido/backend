<?php
namespace App\Http\Controllers\Api\V1;

use App\Event;
use App\Media;
use App\Http\Resources\MediaResource;
use App\Http\Requests\Events\Medias\StoreRequest;
use App\Http\Requests\Events\Medias\DeleteRequest;
use App\Http\Requests\Events\Medias\UpdateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\Events\Medias\ReorderRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventMediaController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param Event $event
     * @return MediaResource
     */
    public function store(StoreRequest $request, Event $event): MediaResource
    {
        return new MediaResource($event->addMedia($request->file)->toMediaCollection('images'));
    }

    /**
     * @param UpdateRequest $request
     * @param Event $event
     * @param Media $media
     * @return MediaResource
     */
    public function update(UpdateRequest $request, Event $event, Media $media): MediaResource
    {
        $media->order_column = (int) $request->order;
        $media->save();
        return new MediaResource($media);
    }

    /**
     * @param ReorderRequest $request
     * @param Event $event
     * @return AnonymousResourceCollection
     */
    public function reorder(ReorderRequest $request, Event $event): AnonymousResourceCollection
    {
        Media::setNewOrder(array_values($request->medias));
        return MediaResource::collection($event->media()->get());
    }

    /**
     * @param DeleteRequest $request
     * @param Event $event
     * @param Media $media
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, Event $event, Media $media): JsonResponse
    {
        $media->delete();
        return response()->noContent();
    }
}
