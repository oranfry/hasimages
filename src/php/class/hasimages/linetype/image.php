<?php
namespace hasimages\linetype;

class image extends \Linetype
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'image';

        $this->fields = [
            'content' => function ($records) : string {
                return base64_encode($records['/']->content);
            },
        ];

        $this->unfuse_fields = [
            'content' => function ($line, $oldline) : string {
                return base64_decode($line->content);
            },
        ];
    }

    function validate($line)
    {
        $errors = [];

        if (imagecreatefromstring(base64_decode($line->content)) === false) {
            $errors[] = 'not valid image data';
        }

        return $errors;
    }
}
