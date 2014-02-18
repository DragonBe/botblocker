<?php

namespace Botblocker;


class BotblockerFilter extends \FilterIterator
{
    protected $ipFilter;

    public function __construct(\Iterator $iterator, $filter)
    {
        parent::__construct($iterator);
        $this->ipFilter = $filter;
    }

    public function accept()
    {
        $ip = $this->getInnerIterator()->current();
        $ip = str_replace('*','', $ip);
        if (stristr($ip, $this->ipFilter)) {
            return true;
        }
        return false;
    }
} 