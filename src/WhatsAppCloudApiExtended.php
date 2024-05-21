<?php

namespace AiluraCode\Wappify;

use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;
use Netflie\WhatsAppCloudApi\Message\Contact\ContactName;
use Netflie\WhatsAppCloudApi\Message\Contact\Phone;
use Netflie\WhatsAppCloudApi\Message\Media\MediaID;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use Netflie\WhatsAppCloudApi\Response;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WhatsAppCloudApiExtended extends WhatsAppCloudApi
{
    /**
     * Sends a Whatsapp text message.
     *
     * @param string $to          whatsApp ID or phone number for the person you want to send a message to
     * @param string $text        the body of the text message
     * @param bool   $preview_url determines if show a preview box for URLs contained in the text message
     *
     * @throws ResponseException
     */
    public function sendTextMessage(string $to, string $text, bool $preview_url = false): Response
    {
        $response = parent::sendTextMessage($to, $text, $preview_url);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a document uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some document uploaded on Internet.
     *
     * @param string  $to          whatsApp ID or phone number for the person you want to send a message to
     * @param MediaID $document_id whatsApp Media ID or any Internet public document link
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendDocument(string $to, MediaID $document_id, string $name, ?string $caption): Response
    {
        $response = parent::sendDocument($to, $document_id, $name, $caption);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a message template.
     *
     * @param string         $to            whatsApp ID or phone number for the person you want to send a message to
     * @param string         $template_name name of the template to send
     * @param string         $language      Language code
     * @param Component|null $components
     *
     * @return Response
     *
     * @throws ResponseException
     *
     * @see https://developers.facebook.com/docs/whatsapp/api/messages/message-templates#supported-languages See language codes supported.
     */
    public function sendTemplate(string $to, string $template_name, string $language = 'en_US', ?Component $components = null): Response
    {
        $response = parent::sendTemplate($to, $template_name, $language, $components);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends an audio uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some audio uploaded on Internet.
     *
     * @param string  $to       whatsApp ID or phone number for the person you want to send a message to
     * @param MediaID $audio_id whatsApp Media ID or any Internet public audio link
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendAudio(string $to, MediaID $audio_id): Response
    {
        $response = parent::sendAudio($to, $audio_id);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends an image uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some image uploaded on Internet.
     *
     * @param string  $to       whatsApp ID or phone number for the person you want to send a message to
     * @param string  $caption  description of the specified image file
     * @param MediaID $image_id whatsApp Media ID or any Internet public image link
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendImage(string $to, MediaID $image_id, ?string $caption = ''): Response
    {
        $response = parent::sendImage($to, $image_id, $caption);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a video uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some video uploaded on Internet.
     *
     * @param string  $to       whatsApp ID or phone number for the person you want to send a message to
     * @param MediaID $video_id whatsApp Media ID or any Internet public video link
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendVideo(string $to, MediaID $video_id, string $caption = ''): Response
    {
        $response = parent::sendVideo($to, $video_id, $caption);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a sticker uploaded to the WhatsApp Cloud servers by it Media ID or you also
     * can put any public URL of some sticker uploaded on Internet.
     *
     * @param string  $to         whatsApp ID or phone number for the person you want to send a message to
     * @param MediaID $sticker_id whatsApp Media ID or any Internet public sticker link
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendSticker(string $to, MediaID $sticker_id): Response
    {
        $response = parent::sendSticker($to, $sticker_id);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a location.
     *
     * @param string $to        whatsApp ID or phone number for the person you want to send a message to
     * @param float  $longitude longitude position
     * @param float  $latitude  latitude position
     * @param string $name      name of location sent
     * @param string $address   address of location sent
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendLocation(string $to, float $longitude, float $latitude, string $name = '', string $address = ''): Response
    {
        $response = parent::sendLocation($to, $longitude, $latitude, $name, $address);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    /**
     * Sends a contact.
     *
     * @param string      $to       whatsApp ID or phone number for the person you want to send a message to
     * @param ContactName $name     the contact name object
     * @param Phone       ...$phone the contact phone number
     *
     * @return Response
     *
     * @throws ResponseException
     */
    public function sendContact(string $to, ContactName $name, Phone ...$phone): Response
    {
        $response = parent::sendContact($to, $name, ...$phone);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    public function sendList(string $to, string $header, string $body, string $footer, Action $action): Response
    {
        $response = parent::sendList($to, $header, $body, $footer, $action);
        Wappify::raise($response)->get()->save();

        return $response;
    }

    public function sendButton(string $to, string $body, ButtonAction $action, ?string $header = null, ?string $footer = null): Response
    {
        $response = parent::sendButton($to, $body, $action, $header, $footer);
        Wappify::raise($response)->get()->save();

        return $response;
    }
}
