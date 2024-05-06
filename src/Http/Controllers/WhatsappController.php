<?php

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Jobs\WhatsappReceiveMessageJob;
use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Wappify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Netflie\WhatsAppCloudApi\WebHook;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;

final class WhatsappController extends Controller
{
    public function webhook()
    {
        $webhook = new WebHook();
        echo $webhook->verify($_GET, env('WHATSAPP_API_TOKEN_VERIFICATION'));
        //return response()->json(['message' => 'Webhook verified']);
    }

    public function receive()
    {
        $payload = file_get_contents('php://input');
        WhatsappReceiveMessageJob::dispatch($payload)
            ->onQueue(config('wappify.queue.name'));
        return response()->json(['message' => 'Message received']);;
    }

    public function index()
    {
        return Whatsapp::paginate(10);
    }

    public function show(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        return $whatsapp;
    }

    public function destroy(string $id, Request $request)
    {
        $withMedia = boolval($request->get('withMedia')) ?? false;
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        $whatsapp->delete();
        if ($withMedia) {
            $whatsapp->media->each(fn ($media) => $media->delete());
            return Response::json(['message' => 'Whatsapp deleted with media']);
        }
        return Response::json(['message' => 'Whatsapp deleted']);
    }

    public function stream(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        if (!$whatsapp->type->isDownloadable()) {
            return Response::json(['message' => 'Message is not a media'], 400);
        }
        $url = $whatsapp->getMedia(config('wappify.spatie.collection'))->first()->getUrl();
        return response()->redirectTo($url);
    }

    public function download(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        if (!$whatsapp->type->isDownloadable()) {
            return Response::json(['message' => 'Message is not a media'], 400);
        }
        return $whatsapp->getMedia(config('wappify.spatie.collection'))->first();
    }

    public function chat(string $from)
    {
        return Whatsapp::chat($from)->get();
    }

    public function me()
    {
        return Whatsapp::me()->get();
    }

    public function you()
    {
        return Whatsapp::you()->get();
    }

    public function media(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        if ($whatsapp) {
            $collection = config('wappify.spatie.collection');
            if ($whatsapp->hasMedia($collection)) {
                return Response::json($whatsapp->getMedia($collection));
            }
            return Response::json(['message' => 'Media not found'], 404);
        }
        return Response::json(['message' => 'Whatsapp not found'], 404);
    }
}
