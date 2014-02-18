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

require_once 'src/autoload.php';
/**
 * Class BotblockerTest
 *
 * Testing the application
 *
 * @package Botblocker
 */
class BotblockerTest extends \PHPUnit_Framework_TestCase
{
    public function ipProvider()
    {
        return array (
            array ('127.0.0.1'),
            array ('192.196.1.1'),
            array ('fe80::1%lo0'),
            array ('::1'),
        );
    }

    /**
     * @dataProvider ipProvider
     */
    public function testNormalIpGetsBlocked($ip)
    {
        $botblocker = new Botblocker();
        $botblocker->addIp($ip);
        $_SERVER['REMOTE_ADDR'] = $ip;
        $this->assertTrue($botblocker->isBlocked());
    }

    /**
     * @dataProvider ipProvider
     */
    public function testIpGetsBlockedIfInCollection($ip)
    {
        $botblocker = new Botblocker();
        foreach ($this->ipProvider() as $element) {
            $botblocker->addIp(array_values($element));
        }
        $_SERVER['X_FORWARDED_FOR'] = $ip;
        $this->assertTrue($botblocker->isBlocked());
    }

    /**
     * @dataProvider ipProvider
     */
    public function testWildcardIpBlocking($ip)
    {
        $botblocker = new Botblocker();
        $botblocker->addIp('127.0.*');
        $botblocker->addIp('*.168.1.1');
        $botblocker->addIp('192.168.1.*');
        $_SERVER['HTTP_CLIENT_IP'] = $ip;
        $this->assertTrue($botblocker->isBlocked());
    }
} 