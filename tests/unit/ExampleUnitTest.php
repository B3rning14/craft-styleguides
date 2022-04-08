<?php
/**
 * styleguides plugin for Craft CMS 3.x
 *
 * Creates a simple styleguide
 *
 * @link      https://www.b3rning14.fr
 * @copyright Copyright (c) 2022 B3rning14
 */

namespace b3rning14craftstyleguides\styleguidestests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use b3rning14craftstyleguides\styleguides\Styleguides;

/**
 * ExampleUnitTest
 *
 *
 * @author    B3rning14
 * @package   Styleguides
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            Styleguides::class,
            Styleguides::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
