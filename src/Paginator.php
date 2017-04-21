<?php

namespace rgehan\paginator;

use InvalidArgumentException;
use Exception;

class Paginator
{
    private $itemsCount;
    private $itemsPerPage;
    private $pagesCount;
    private $urlFormatString;

    /**
     * Builds the paginator
     * @param {integer} $count   Total number of items to paginate
     * @param {integer} $perPage Number of items per page
     */
    public function __construct($count, $perPage)
    {
        if($count < 0)
            throw new InvalidArgumentException("Items count cannot be negative");

        if($perPage <= 0)
            throw new InvalidArgumentException("Items count per page cannot be negative nor null");

        $this->itemsCount = $count;
        $this->itemsPerPage = $perPage;

        $this->pagesCount = ceil($this->itemsCount / $this->itemsPerPage);
    }

    /**
     * Sets the format string that will be used to generate pages URLs
     * @param $urlFormatString A C-style format string (use %d to inject the page id)
     */
    public function setURLFormatString($urlFormatString)
    {
        $this->urlFormatString = $urlFormatString;
    }

    /**
     * Generates all the links for the pagination
     * @param {integer} $currentPage Optional. The current page
     */
    public function generateLinks($currentPage = null)
    {
        if(!$this->urlFormatString)
            throw new Exception("The URL format string must be provided");

        $links = [];

        for($i = 0; $i < $this->pagesCount; $i++)
        {
            $links[] = [
                'url' => sprintf($this->urlFormatString, $i),
                'index' => $i,
                'current' => ($i == $currentPage)
            ];
        }

        return $links;
    }

    /**
     * Returns a page that is guaranteed to be in the correct range
     * @param  {integer} $page The page we want to access
     * @return {integer}       The closest valid page
     */
    public function getValidPage($page)
    {
        return max(0, min($this->pagesCount - 1, $page));
    }
}
