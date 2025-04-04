<?php

namespace View;

use Twig_Environment;
use Twig_SimpleFilter;

final class FiltersExtension extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter(
                'img_path',
                [$this, 'imgPath'],
                ['needs_environment' => true]
            ),
            new \Twig\TwigFilter(
                'link',
                [$this, 'link'],
                ['is_safe' => ['html']]
            ),
            new \Twig\TwigFilter(
                'format_date',
                [$this, 'formatDate']
            )
        ];
    }

    /**
     * @param string           $suffix
     *
     * @throws \Twig\Error\RuntimeError
     */
    public function imgPath(\Twig\Environment $env, $suffix, string $infix): string
    {
        if (!$suffix && $infix === 'event_icons') {
            $suffix = 'none.png';
        }

        $path = '/img/' . $infix . '/' . $suffix;

        // Allow for migration to local images
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
            $uri = $env->getExtension('slim')->base();

            return $uri . $path;
        }

        return 'https://joind.in/inc' . $path;
    }

    /**
     * @param string $date
     *
     * @return false|string
     */
    public function formatDate($date): string
    {
        return date('D M dS Y', strtotime($date));
    }

    /**
     * @param string $label
     *
     */
    public function link(string $url, $label = '', string $class = ''): string
    {
        return '<a href="' . $url . '" class="' . $class . '">' . ($label ?: $url) . '</a>';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return self::class;
    }
}
