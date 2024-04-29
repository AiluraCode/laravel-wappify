<?php

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Http\Clients\WhatsappMediaDownloader;
use AiluraCode\Wappify\Jobs\WhatsappReceiveJob;
use AiluraCode\Wappify\Models\Whatsapp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

final class WhatsappController extends Controller
{
    public function webhook(): void
    {
        //echo webhook();
    }

    public function receive()
    {
        $payload = file_get_contents('php://input');
        WhatsappReceiveJob::dispatch($payload, config('wappify.save'))
            ->onQueue(config('wappify.queue_messages'));
        exit();
    }

    public function index()
    {
        return Whatsapp::all();
    }

    public function history(string $from)
    {
        return Whatsapp::where('from', $from)->get();
    }

    public function media(string $id)
    {
        return Whatsapp::where('wa_id', $id)->get();
    }

    public function stream(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        $file = $whatsapp->stream();
        $headers = [
            "Content-Type" => $whatsapp->message['mime_type'],
            "Content-Disposition" => "inline; filename=" . uniqid()
        ];
        return Response::download($file, uniqid(), $headers);
    }

    public function download(string $id)
    {
        $whatsapp = Whatsapp::find($id);
        $whatsapp->addMediaFromStream($whatsapp->stream())
            ->usingFileName($whatsapp->getFilename())
            ->toMediaCollection();
    }
}
