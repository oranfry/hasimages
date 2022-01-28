<?php
namespace hasimages\linetype;

class imageplain extends \Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'image';
    }
}
