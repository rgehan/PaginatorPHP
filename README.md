## [rgehan/paginator-php](https://github.com/rgehan/paginator-php)

This is a quick implementation of a paginator for a project

## Installation
Simply require it with composer:
```
composer require rgehan/paginator
```

## Usage
```php

define('ITEMS_PER_PAGE', 3);

// Gets the count of articles
$articlesCount = 10; // You might want to load that from the database

// Makes pagination
$paginator = new Paginator($articlesCount, self::ITEMS_PER_PAGE);
$paginator->setURLFormatString("http://localhost/articles?page=%d");

// Gets the page we want to access
if(isset($_GET['page']))
    $page = $paginator->getValidPage($_GET['page']); // Returns a page in the range of the existing pages
else
    $page = 0;

// Fetches the articles
$startIndex = $page * self::ITEMS_PER_PAGE;
$articles = do_sql_query("SELECT * FROM articles LIMIT " . $startIndex . ", " . ITEMS_PER_PAGE); // Pseudo-code for SQL query

// Creates the pagination
$pagination = $paginator->generateLinks($page);

/*
    Let's say: $page = 2

    Outputs:
    [
        [
            'url' => 'http://localhost/articles?page=0',
            'index' => 0,
            'current' => false
        ],[
            'url' => 'http://localhost/articles?page=1',
            'index' => 1,
            'current' => false
        ],[
            'url' => 'http://localhost/articles?page=2',
            'index' => 2,
            'current' => true
        ],[
            'url' => 'http://localhost/articles?page=3',
            'index' => 3,
            'current' => false
        ],
        ...
    ]
 */
```

You can then pass the output of `$paginator->generateLinks($page)` to your view and render your links as you wish.