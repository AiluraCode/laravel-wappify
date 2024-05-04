<?php

use AiluraCode\Wappify\Wappify;
use PHPUnit\Framework\TestCase;

class WappifyTest extends TestCase
{
    private $payload = '{"object":"whatsapp_business_account","entry":[{"id":"240297092497020","changes":[{"value":{"messaging_product":"whatsapp","metadata":{"display_phone_number":"15551335615","phone_number_id":"255764720944895"},"contacts":[{"profile":{"name":"James"},"wa_id":"593960800736"}],"messages":[{"from":"593960800736","id":"wamid.HBgMNTkzOTYwODAwNzM2FQIAEhggNjVDQUU5RDU3NjQ2MkVERkJDQTY0MkFGRTIxQkFEREIA","timestamp":"1714177199","type":"video","video":{"mime_type":"video/mp4","sha256":"W7Y8A0+6IiEh5Mgs38h6AcX0rkuBDKev4V1BiLld50Y=","id":"6941843725920193"}}]},"field":"messages"}]}]}';

    public function testCatchMethod()
    {
        $result = Wappify::catch($this->payload);

        echo $result->get();

        $this->assertInstanceOf(Wappify::class, $result);
    }

    public function testPayloadToModel()
    {
        $result = Wappify::payloadToModel($this->payload);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('from', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('timestamp', $result);
    }

    public function testCatchMethodWithInvalidPayload()
    {
        $this->expectException(InvalidArgumentException::class);

        Wappify::catch('invalid_payload');
    }
}
