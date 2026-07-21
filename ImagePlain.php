<?php

namespace OranFry\HasImages\Linetypes;

class ImagePlain extends \OranFry\Jars\Core\Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'image';
    }
}
