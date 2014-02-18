# Botblocker

Sometimes you need a quick way to block nasty bots or automated scripts from your PHP application, with Botblocker you can quickly create a list of IP's you want to restrict from accessing.

Usage is simple, using PSR-0 autoloading.

    <?php
    require_once '/path/to/botblocker/autoload.php';

    $botBlocker = new \Botblocker\Botblocker;

    // Add a single IP
    $botBlocker->addIp('127.0.0.1');

    // Add a block range
    $botBlocker->addIp('192.168.*');
    $botBlocker->addIp('*.0.1');

    // Check if a requesting IP is in blacklist
    $result = $botBlocker->isBlocked();

See [tests/BotblockerTest.php](tests/BotblockerTest.php) for some common examples.