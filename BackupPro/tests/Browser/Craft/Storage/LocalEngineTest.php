<?php
/**
 * mithra62 - Backup Pro
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		3.0
 * @filesource 	./mithra62/BackupPro/tests/Browser/Craft/Storage/LocalEngineTest.php
 */

namespace mithra62\BackupPro\tests\Browser\Craft\Storage;

use mithra62\BackupPro\tests\Browser\AbstractBase\Storage\LocalEngine; 
use mithra62\BackupPro\tests\Browser\CraftTrait;

/**
 * mithra62 - (Selenium) Locald Storage Engine object Unit Tests
 *
 * Executes all the tests by platform using the below definitions
 *
 * @package 	mithra62\Tests
 * @author		Eric Lamb <eric@mithra62.com>
 */
class LocalEngineTest extends LocalEngine
{
    use CraftTrait;

    /**
     * Disable this since we want full browser support
     */
    public function setUp()
    {
    
    }
    
    /**
     * Disable this since we want full browser support
     */
    public function teardown()
    {
    
    }
    
}