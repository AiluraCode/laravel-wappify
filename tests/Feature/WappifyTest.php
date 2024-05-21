<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Tests\Feature;

use AiluraCode\Wappify\Entities\BaseMessage;
use AiluraCode\Wappify\Entities\Media\BaseMediaMessage;
use AiluraCode\Wappify\Entities\Media\VideoMessage;
use AiluraCode\Wappify\Tests\TestCase;
use AiluraCode\Wappify\Wappify;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use InvalidArgumentException;

class WappifyTest extends TestCase
{
    use DatabaseMigrations;

    private string $payload;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = strval(file_get_contents(__DIR__ . '/../../stubs/messageText.stub.json'));
    }

    /**
     * Test catch method.
     *
     * @throws Exception
     */
    public function testCatchMethod(): void
    {
        $result = Wappify::catch($this->payload);
        $this->assertInstanceOf(Wappify::class, $result);
    }

    /**
     * @throws Exception
     */
    public function testPayloadToModel(): void
    {
        $result = Wappify::payloadToModel($this->payload);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('wamid', $result);
        $this->assertArrayHasKey('from', $result);
        $this->assertArrayHasKey('type', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('timestamp', $result);
    }

    /**
     * @throws Exception
     */
    public function testCatchMethodWithInvalidPayload(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Wappify::catch('invalid_payload');
    }

    /**
     * @throws Exception
     */
    public function testSaveMethod(): void
    {
        $whatsapp = Wappify::catch($this->payload)->get();
        $result = $whatsapp->save();

        $this->assertTrue($result);

        $this->assertDatabaseHas('whatsapp', [
            'wamid'     => $whatsapp->wamid,
            'profile'   => $whatsapp->profile,
            'from'      => $whatsapp->from,
            'type'      => $whatsapp->type,
            'message'   => json_encode($whatsapp->message),
            'timestamp' => $whatsapp->timestamp,
        ]);

        $this->assertIsObject($whatsapp->message);
        // @phpstan-ignore-next-line
        $this->assertIsString($whatsapp->message->id);
    }

    /**
     * @throws Exception
     */
    public function testCast(): void
    {
        $whatsapp = Wappify::catch($this->payload)->get();
        $this->assertTrue($whatsapp->isVideo());
        $this->assertTrue($whatsapp->getType()->isDownloadable());
        $video = $whatsapp->toMedia();
        $this->assertIsObject($video);
        $this->assertInstanceOf(BaseMessage::class, $video);
        $this->assertInstanceOf(BaseMediaMessage::class, $video);
        $this->assertInstanceOf(VideoMessage::class, $video);
    }
}
