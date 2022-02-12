<?php
namespace hasimages\linetype;

class imageplain extends \jars\Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'image';
    }
}
