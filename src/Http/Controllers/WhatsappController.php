<?php

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Http\Clients\WhatsappClientDownloader;
use AiluraCode\Wappify\Jobs\WhatsappReceiveJob;
use AiluraCode\Wappify\Models\Whatsapp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Netflie\WhatsAppCloudApi\WebHook;

final class WhatsappController extends Controller
{
    public function webhook(): void
    {
        $webhook = new WebHook();
        echo $webhook->verify($_GET, env('WHATSAPP_API_TOKEN_VERIFICATION'));
    }

    public function receive()
    {
        $payload = file_get_contents('php://input');
        WhatsappReceiveJob::dispatch($payload, config('wappify.save'))
            ->onQueue(config('wappify.queue'));
        return response()->json(['message' => 'Message received']);;
    }

    public function index()
    {
        return Whatsapp::all();
    }

    public function show(string $id)
    {
        $whatsapp = Whatsapp::with('media')->find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        return Whatsapp::with('media')->find($id);
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

    public function download(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        try {
            WhatsappClientDownloader::download($whatsapp);
            return Response::json(['message' => 'Media downloaded']);
        } catch (\Throwable $th) {
            return Response::json(['message' => 'Error downloading media'], 500);
        }
    }
}
