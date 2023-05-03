<?php

namespace hasimages\linetype;

class imagemeta extends \hasimages\linetype\imagemetaplain
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

    public function unpack($line, $oldline, $old_inlines)
    {
        parent::unpack($line, $oldline, $old_inlines);

        if (@$line->content) {
            $line->image = (object) [
                'content' => $line->content,
            ];
        }
    }
}
