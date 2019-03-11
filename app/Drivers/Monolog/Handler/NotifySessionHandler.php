<?php

namespace App\Drivers\Monolog\Handler;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class NotifySessionHandler extends AbstractProcessingHandler
{
    const NOTIFY_TYPE_KEY = 'Type';
    const NOTIFY_TITLE_KEY = 'Title';
    const NOTIFY_MSG_KEY = 'Message';

    private $prefix;

    public function __construct($prefix = 'nt', $level = Logger::INFO, bool $bubble = true)
    {
        $this->prefix = $prefix;
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler.
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        $this->flashNotifyType($record['level_name']);

        $this->flashNotifyTitle($record['context']);

        $this->flashNotifyMessage($record['message']);
    }

    private function flashNotifyType($level)
    {
        session()->flash($this->prefix.static::NOTIFY_TYPE_KEY,
            $this->getNotifyType($level)
        );
    }

    private function flashNotifyTitle($context)
    {
        if( isset($context['title']) ){
            session()->flash($this->prefix.static::NOTIFY_TITLE_KEY, $context['title']);
        }
    }

    private function flashNotifyMessage($message)
    {
        session()->flash($this->prefix.static::NOTIFY_MSG_KEY, $message);
    }

    private function getNotifyType($level)
    {
        return ( $level === 'INFO' ) ? 'success':'error';
    }
}