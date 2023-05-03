<?php

namespace hasimages\linetype;

class imagemetaplain extends \jars\Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'imagemeta';

        $this->simple_string('title');

        $this->borrow['image_id'] = function ($line) {
            return @$line->image->id;
        };

        $this->inlinelinks = [
            (object) [
                'linetype' => 'imageplain',
                'property' => "image",
                'tablelink' => "imagemeta_image",
            ],
        ];
    }

    function unpack($line, $oldline, $old_inlines)
    {
        $line->image = 'unchanged';
    }
}
