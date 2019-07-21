<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnalyzeContent extends AbstractController
{
    public function analyzeContent($content)
    {
        $content_exploded = explode(' ', $content);
        $find = false;

        $types_posts = [
            "netflix",
            'adn',
            'spotify',
            'deezer',
            'wakanim',
            'anime digital network'
        ];

        foreach ($content_exploded as $content_e) {
            if (in_array($content_e, $types_posts)) {
                $type = $content_e;
                $find = true;
                break;
            }
        }
        if ($find) {
            return $type;
        } else {
            return "undefined";
        }
    }

}