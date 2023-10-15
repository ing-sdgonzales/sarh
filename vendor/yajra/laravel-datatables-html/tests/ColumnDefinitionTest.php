<?php

namespace Yajra\DataTables\Html\Tests;

use Yajra\DataTables\Html\ColumnDefinition;

class ColumnDefinitionTest extends TestCase
{
    /** @test */
    public function it_has_property_setters()
    {
        $def = ColumnDefinition::make()
                               ->targets([1])
                               ->columns([])
                               ->cellType()
                               ->className('my-class')
                               ->contentPadding('mmm')
                               ->createdCell('fn');

        $this->assertEquals([1], $def->targets);
        $this->assertEquals([], $def->columns);
        $this->assertEquals('th', $def->cellType);
        $this->assertEquals('my-class', $def->className);
        $this->assertEquals('mmm', $def->contentPadding);
        $this->assertEquals('fn', $def->createdCell);
    }

}