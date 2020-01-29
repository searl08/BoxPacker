<?php
/**
 * Box packing (3D bin packing, knapsack problem).
 *
 * @author Doug Wright
 */
declare(strict_types=1);

namespace DVDoug\BoxPacker;

use DVDoug\BoxPacker\Test\LimitedSupplyTestBox;
use DVDoug\BoxPacker\Test\TestBox;
use DVDoug\BoxPacker\Test\TestItem;
use function iterator_to_array;
use PHPUnit\Framework\TestCase;

class PackerTest extends TestCase
{
    /**
     * From issue #187.
     */
    public function testIssue187(): void
    {
        $packer = new Packer();
        $packer->addBox(new TestBox('1150x850x75xBubbleEnvelope', 850, 1150, 100, 31, 838, 1125, 75, 7000));
        $packer->addBox(new TestBox('900x700x400-Box', 700, 900, 400, 50, 675, 875, 375, 7000));
        $packer->addBox(new TestBox('1400x1000x600-Box', 1000, 1400, 600, 50, 975, 1375, 575, 7000));
        $packer->addBox(new TestBox('1800x1400x600-Box', 1400, 1800, 600, 50, 1375, 1775, 575, 7000));
        $packer->addBox(new TestBox('1400x1400x800-Box', 140, 140, 80, 50, 1375, 1375, 775, 7000));
        $packer->addBox(new TestBox('2625x1050x800-Box', 1050, 2625, 800, 50, 1025, 2600, 775, 7000));
        $packer->addBox(new TestBox('2550x1400x825-Box', 1300, 2550, 825, 50, 1275, 2525, 800, 7000));
        $packer->addBox(new TestBox('3200x1200x900-Box', 1200, 3200, 900, 50, 1175, 3175, 875, 7000));
        $packer->addBox(new TestBox('2300x2200x1800-Box', 2200, 2300, 1800, 50, 2175, 2275, 1775, 7000));
        $packer->addBox(new TestBox('2200x1800x2700-Box', 1800, 2200, 2700, 50, 1775, 2175, 2675, 7000));
        $packer->addBox(new TestBox('2700x2200x1800-Box', 2200, 2700, 18, 50, 2175, 2675, 1775, 7000));

        $packer->addItem(new TestItem('Test Item 1 - 800 x 475 x 150', 475, 800, 150, 68, false), 25);
        $packer->addItem(new TestItem('Test Item 2 - 750 x 300 x 50', 300, 750, 50, 68, false), 50);
        $packer->addItem(new TestItem('Test Item 3 - 550 x 375 x 25', 375, 550, 25, 9, false), 150);
        $packer->addItem(new TestItem('Test Item 4 - 800 x 475 x 100', 475, 800, 100, 34, false), 30);
        $packer->addItem(new TestItem('Test Item 5 - 2275 x 2175 x 1775', 2175, 2275, 1775, 4500, false), 2);

        /** @var PackedBox[] $packedBoxes */
        $packedBoxes = iterator_to_array($packer->pack(), false);

        self::assertCount(3, $packedBoxes);
        self::assertSame(5548, $packedBoxes[0]->getWeight());
        self::assertSame(5532, $packedBoxes[1]->getWeight());
        self::assertSame(5540, $packedBoxes[2]->getWeight());
    }
}
