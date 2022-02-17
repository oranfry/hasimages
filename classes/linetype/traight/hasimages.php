<?php

namespace hasimages\linetype\traight;

use Exception;

trait hasimages
{
    protected function hasimages_init()
    {
        if (!array_key_exists('comment', $this->fields)) {
            throw new Exception('Hasimages requires a comment field (linetype class "' . static::class . '")');
        }

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
        foreach (static::IMAGE_SIZES as $image => $details) {
            if (@$line->{"{$image}_image_id"}) {
                $child = $line->{"{$image}_image"} = (object) [
                    'title' => implode(' - ', array_filter([ucfirst($this->table), ucfirst($image), @$line->comment])),
                ];

                $line->{"{$image}_image"} = $child;
            }
        }
    }
}
