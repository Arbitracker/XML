<?php
/**
 * arbit main test suite
 *
 * @version $Revision: 926 $
 * @license LGPLv3
 */

/*
 * Set file whitelist for phpunit
 */

/**
 * Test suites
 */
require 'xml_suite.php';

/**
* Test suite for arbit
*/
class arbitTestSuite extends PHPUnit_Framework_TestSuite
{
    /**
     * Basic constructor for test suite
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'arbitWrapper - A PHP version control system wrapper' );

        $this->addTestSuite( arbitXmlTestSuite::suite() );
    }

    /**
     * Return test suite
     * 
     * @return prpTestSuite
     */
    public static function suite()
    {
        return new arbitTestSuite( __CLASS__ );
    }
}

