<?php

namespace NotificationChannels\Clicksend;

class ClicksendMessage
{
		public $body;
		
		public $from;
		
		public $to;

    public static function create($body = '')
    {
        return new static($body);
    }

    public function __construct($body = '')
    {
        if (! empty($body)) {
            $this->body = trim($body);
        }
    }

    public function setBody($body)
    {
        $this->body = trim($body);

        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function setRecipient($recipient)
    {
        $this->to = $recipient;

        return $this;
    }

    public function toJson()
    {
        return json_encode([
					'messages' => [$this]
				]);
    }
}
