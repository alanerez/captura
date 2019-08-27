<?php

namespace Modules\Core\Services;

class ColorService
{
    public function getTextColor($hex)
    {
        list($red, $green, $blue) = sscanf($hex, "#%02x%02x%02x");
        $luma = ($red + $green + $blue) / 3;
        if ($luma < 128) {
            $textcolour = "text-light";
        } else {
            $textcolour = "text-dark";
        }
        return $textcolour;
    }
}
