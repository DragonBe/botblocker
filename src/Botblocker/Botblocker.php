<?php

namespace Botblocker;

class Botblocker extends \ArrayIterator
{
    protected $blocked;

    public function __construct()
    {
        $this->blocked = new \ArrayIterator();
    }

    public function addIp($ip)
    {
        $this->blocked->append($ip);
        return $this;
    }

    public function getBlocked()
    {
        return $this->blocked->getArrayCopy();
    }

    public function getRemoteIp()
    {
        $ipaddress = '';
        if (isset ($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset ($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset ($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset ($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset ($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        if (!filter_var($ipaddress, FILTER_VALIDATE_IP)) {
            return false;
        }
        return $ipaddress;
    }

    public function isBlocked()
    {
        $filter = new BotblockerFilter($this->blocked, $this->getRemoteIp());
        return count($filter) === 0 ? false : true;
    }
}