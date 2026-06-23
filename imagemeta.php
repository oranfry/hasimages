<?php

namespace OranFry\HasImages\Linetype;

class imagemeta extends imagemetaplain
{
    function __construct()
    {
        parent::__construct();

        $this->borrow['content'] = function ($line) {
            return $line->image->content;
        };

        $this->inlinelinks = [
            (object) [
                'linetype' => 'image',
                'property' => "image",
                'tablelink' => "imagemeta_image",
            ],
        ];
    }

    public function unpack($line, $oldline)
    {
        parent::unpack($line, $oldline);

        if (@$line->content) {
            $line->image = (object) [
                'content' => $line->content,
            ];
        }
    }
}
