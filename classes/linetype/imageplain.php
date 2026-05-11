<?php

namespace hasimages\linetype;

class imageplain extends \OranFry\Jars\Core\Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'image';
    }
}
