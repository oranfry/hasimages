<?php

namespace hasimages\linetype\traight;

trait hasimages
{
    protected function hasimages_init()
    {
        foreach (static::IMAGE_SIZES as $image => $details) {
            $this->fields["{$image}_image_id"] = function ($records) use ($image) : ?string {
                if (@$records["/{$image}_image/image"]->id) {
                    return (string) $records["/{$image}_image/image"]->id;
                }

                return null;
            };

            $this->inlinelinks[] = (object) [
                'linetype' => 'imagemetaplain',
                'property' => "{$image}_image",
                'tablelink' => "{$image}image",
            ];
        }
    }

    protected function hasimages_unpack($line, $oldline, $old_inlines)
    {
        if (!property_exists($line, 'comment')) {
            error_response('Hasimages requires a line comment (linetype "' . $this->name . '")');
        }

        foreach (static::IMAGE_SIZES as $image => $details) {
            if (@$line->{"{$image}_image_id"}) {
                $child = $line->{"{$image}_image"} = (object) [
                    'title' => implode(' - ', array_filter([ucfirst($this->table),  ucfirst($image), $line->comment])),
                ];

                $line->{"{$image}_image"} = $child;
            }
        }
    }
}
