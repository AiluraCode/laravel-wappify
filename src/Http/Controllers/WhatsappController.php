<?php

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Jobs\WhatsappReceiveJob;
use AiluraCode\Wappify\Wappify;
use App\Http\Controllers\Controller;

final class WhatsappController extends Controller
{
    public function webhook(): void
    {
        //echo webhook();
    }

    public function receive()
    {
        $payload = file_get_contents('php://input');
        WhatsappReceiveJob::dispatchAfterResponse($payload)
            ->onQueue('whatsapp_receive');
        exit();
    }
}
