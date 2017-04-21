<?php

use PHPUnit\Framework\TestCase;
use rgehan\paginator\Paginator;

/**
 * @covers Paginator
 */
final class PaginatorTest extends TestCase
{
    public function testCanBeCreatedFromValidCounts()
    {
        $this->assertInstanceOf(
            Paginator::class,
            $paginator = new Paginator(10, 3)
        );
    }

    public function testCannotBeCreatedFromNegativeCount()
    {
        $this->expectException(InvalidArgumentException::class);

        $paginator = new Paginator(-1, 3);
    }

    public function testCannotBeCreatedFromInvalidPerPageCount()
    {
        $this->expectException(InvalidArgumentException::class);

        $paginator = new Paginator(10, 0);
    }

    public function testCannotGenerateWithoutPrefixURL()
    {
        $paginator = new Paginator(10, 3);

        $this->expectException(Exception::class);

        $paginator->generateLinks();
    }

    public function testCanGenerateWithPrefixURL()
    {
        $paginator = new Paginator(10, 3);
        $paginator->setURLFormatString("server.tld/page=%d");

        $this->assertNotEmpty($paginator->generateLinks());
    }

    public function testReturnValidPageCountOnPositiveItemCount()
    {
        $paginator = new Paginator(10, 3);
        $paginator->setURLFormatString("server.tld/page=%d");

        $this->assertCount(4, $paginator->generateLinks());
    }

    public function testReturnValidPageCountOnNullItemCount()
    {
        $paginator = new Paginator(0, 3);
        $paginator->setURLFormatString("server.tld/page=%d");

        $this->assertCount(0, $paginator->generateLinks());
    }

    public function testPageMappedToRangeWhenNegative()
    {
        $paginator = new Paginator(10, 3);

        $this->assertEquals(0, $paginator->getValidPage(-3));
    }

    public function testPageMappedToRangeWhenTooBig()
    {
        $paginator = new Paginator(10, 3);

        $this->assertEquals(3, $paginator->getValidPage(12));
    }
}
