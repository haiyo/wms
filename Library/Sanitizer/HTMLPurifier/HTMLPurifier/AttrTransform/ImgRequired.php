<?php

// must be called POST validation

/**
 * Transform that supplies default values for the src and alt attributes
 * in images tags, as well as prevents the images tag from being removed
 * because of a missing alt tag. This needs to be registered as both
 * a pre and post attribute transform.
 */
class HTMLPurifier_AttrTransform_ImgRequired extends HTMLPurifier_AttrTransform
{

    public function transform($attr, $config, $context) {

        $src = true;
        if (!isset($attr['src'])) {
            if ($config->get('Core.RemoveInvalidImg')) return $attr;
            $attr['src'] = $config->get('Attr.DefaultInvalidImage');
            $src = false;
        }

        if (!isset($attr['alt'])) {
            if ($src) {
                $alt = $config->get('Attr.DefaultImageAlt');
                if ($alt === null) {
                    // truncate if the alt is too long
                    $attr['alt'] = substr(basename($attr['src']),0,40);
                } else {
                    $attr['alt'] = $alt;
                }
            } else {
                $attr['alt'] = $config->get('Attr.DefaultInvalidImageAlt');
            }
        }

        return $attr;

    }

}

// vim: et sw=4 sts=4
