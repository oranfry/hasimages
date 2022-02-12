<?php
namespace hasimages\linetype;

use Linetype;

class imageset extends \jars\Linetype
{
    public $image_sizes;

    function __construct()
    {
        parent::__construct();

        $this->fields['comment'] = function ($records) {
            return $records['/']->comment;
        };

        foreach ($this->image_sizes as $image => $details) {
            $this->borrow[$image] = function ($line) use ($image) : ?string {
                return @$line->{"{$image}_image"}->content ? (string) $line->{"{$image}_image"}->content : null;
            };

            $this->inlinelinks[] = (object) [
                'linetype' => 'imagemeta',
                'property' => "{$image}_image",
                'tablelink' => "{$image}image",
            ];
        }
    }

    public function unpack($line, $oldline, $old_inlines)
    {
        parent::unpack($line, $oldline, $old_inlines);

        foreach ($this->image_sizes as $image => $details) {
            $line->{"{$image}_image"} = @$line->$image ? (object) [
                'content' => $line->$image,
                'title' => implode(' - ', array_filter([ucfirst($this->table), ucfirst($image), @$line->comment])),
            ] : 'unchanged';
        }
    }

    function validate($line)
    {
        $errors = [];

        foreach ($this->image_sizes as $image => $details) {
            if (@$line->$image) {
                $imagedata = imagecreatefromstring(base64_decode($line->$image));

                if ($imagedata === false) {
                    $errors[] = $image . ' does not contain valid image data';
                } elseif (imagesx($imagedata) !== $details['size'][0] || imagesy($imagedata) !== $details['size'][1]) {
                    $errors[] = "{$image} image should be {$details['size'][0]}x{$details['size'][1]}";
                }
            }
        }

        return $errors;
    }
}
