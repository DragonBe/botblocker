<?php
/**
 * Botblocker
 *
 * A quick way to disable IP's from accessing your web application. This
 * tool is not a fail-proof product, but allows you to block certain IP's
 * from accessing.
 *
 * @author Michelangelo van Dam
 * @package Botblocker
 * @licence Creative Commons Attribution 4.0 International License
 */
namespace Botblocker;
/**
 * Class Botblocker
 *
 * Class that allows you to quickly block unwanted IP's from your
 * web application.
 *
 * @package Botblocker
 */
class Botblocker extends \ArrayIterator
{
    /**
     * @var \ArrayIterator Collection of IP's you want to block
     */
    protected $blocked;

    /**
     * Constructor for this class
     */
    public function __construct()
    {
        $this->blocked = new \ArrayIterator();
    }

    /**
     * Add a single IP for blocking access to the collection
     *
     * @param string $ip
     * @return $this
     */
    public function addIp($ip)
    {
        $this->blocked->append($ip);
        return $this;
    }

    /**
     * Retrieve an array of IP addresses you want to block
     *
     * @return array
     */
    public function getBlocked()
    {
        return $this->blocked->getArrayCopy();
    }

    /**
     * Retrieve the remote IP address requesting access.
     *
     * @return bool|string Will return the IP address making the request or
     * returns FALSE if the IP could not be retrieved.
     */
    public function getRemoteIp()
    {
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

    /**
     * Validator to see if an IP was blocked or not
     *
     * @return bool Will return TRUE if it was blocked, FALSE if not.
     */
    public function isBlocked()
    {
        $filter = new BotblockerFilter($this->blocked, $this->getRemoteIp());
        return count($filter) === 0 ? false : true;
    }
}