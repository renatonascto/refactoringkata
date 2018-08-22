<?php

require_once 'gilded_rose.php';
require_once 'item.php';

use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase {

    function testRegularItemBeforeSellInDate() {
        $items = array(new Item("foo", 5, 2));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(4, $items[0]->sell_in);
        $this->assertEquals(1, $items[0]->quality);
    }

    function testRegularItemAfterSellInDate() {
        $items = array(new Item("foo", -1, 2));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }
    
    function testItemQualityNeverNegative() {
        $items = array(new Item("foo", -1, 1));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }    

    function testAgedItemsBeforeSellIn() {
        $items = array(new Item("Aged Brie", 1, 1));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(2, $items[0]->quality);
    }

    function testAgedItemsAfterSellIn() {
        $items = array(new Item("Aged Brie", -1, 3));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(5, $items[0]->quality);
    }

    function testAgedItemsMaxQuality() {
        $items = array(new Item("Aged Brie", -1, 50));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(-2, $items[0]->sell_in);
        $this->assertEquals(50, $items[0]->quality);
    }

    function testLegendaryItemsQuality() {
        $items = array(new Item("Sulfuras, Hand of Ragnaros", 0, 80));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(0, $items[0]->sell_in);
        $this->assertEquals(80, $items[0]->quality);
    }

    function testTicketsMoreThanTenDaysBeforeSellIn() {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 11, 11));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(10, $items[0]->sell_in);
        $this->assertEquals(12, $items[0]->quality);
    }

    function testTicketsBetweenTenDaysAndFiveDaysBeforeSellIn() {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 9, 11));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(8, $items[0]->sell_in);
        $this->assertEquals(13, $items[0]->quality);
    }

    function testTicketsFiveDaysBeforeSellIn() {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 4, 11));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(3, $items[0]->sell_in);
        $this->assertEquals(14, $items[0]->quality);
    }

    function testTicketsAfterSellIn() {
        $items = array(new Item("Backstage passes to a TAFKAL80ETC concert", 0, 11));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals(-1, $items[0]->sell_in);
        $this->assertEquals(0, $items[0]->quality);
    }    
    
//    function testConjuredItemsBeforeSellIn() {
//        $items = array(new Item("Conjured Mana Cake", 3, 11));
//        $gildedRose = new GildedRose($items);
//        $gildedRose->update_quality();
//        $this->assertEquals(2, $items[0]->sell_in);
//        $this->assertEquals(9, $items[0]->quality);
//    }
    
}
