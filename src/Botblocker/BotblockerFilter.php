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
 * Class BotblockerFilter
 *
 * A simple filter iterator to filter out IP's from your collection
 *
 * @package Botblocker
 */
class BotblockerFilter extends \FilterIterator
{
    /**
     * @var string The IP that needs to be filtered
     */
    protected $ipFilter;

    /**
     * Constructor for this filter
     *
     * @param \Iterator $iterator
     * @param $filter
     */
    public function __construct(\Iterator $iterator, $filter)
    {
        parent::__construct($iterator);
        $this->ipFilter = $filter;
    }

    /**
     * Filter method used internally by the FilterIterator
     *
     * @return bool
     * @see \FilterIterator::accept()
     */
    public function accept()
    {
        $ip = $this->getInnerIterator()->current();
        $ip = str_replace('*','', $ip);
        if (strpos($ip, $this->ipFilter) !== false) {
            return true;
        }
        return false;
    }
} 