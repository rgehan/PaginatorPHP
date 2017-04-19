<?php

namespace rgehan\paginator;

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
        if($page < 0)
            return 0;
        else if($page >= $this->pagesCount)
            return $this->pagesCount - 1;
        else
            return $page;
    }
}