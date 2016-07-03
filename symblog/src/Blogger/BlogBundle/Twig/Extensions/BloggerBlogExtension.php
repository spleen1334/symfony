<?php
// src/Blogger/BlogBundle/Twig/Extensions/BloggerBlogExtension.php

namespace Blogger\BlogBundle\Twig\Extensions;

class BloggerBlogExtension extends \Twig_Extension
{
    /**
     * Override methode kako bismo ubacili nas custom twig extension
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
        return array(
//             'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
                new \Twig_SimpleFilter('created_ago', array($this, 'createdAgo'))
        );
    }

    /**
     * Custom twig ext, prikazuje vreme dodavanja komentara
     * 
     * @param \DateTime $dateTime
     * @throws \InvalidArgumentException
     * @return string
     */
    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp(); // seconds
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // Seconds
            $time = $delta;
            $duration = $time . " second" . (($time > 1 || $time === 0) ? "s" : "") . " ago";
        }
        else if ($delta < 3600)
        {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta < 86400)
        {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " hour" . (($time > 1) ? "s" : "") . " ago";
        }
        else
        {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " day" . (($time > 1) ? "s" : "") . " ago";
        }

        return $duration;
    }

    /**
     * Override za twig extension
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'blogger_blog_extension';
    }
}
