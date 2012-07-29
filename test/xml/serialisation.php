<?php
/**
 * Basic test cases for framework
 *
 * @version $Revision$
 * @license GPLv3
 */

/**
 * Tests for the XML xml serialization
 */
class arbitXmlSerializeTests extends arbitTestCase
{
    /**
     * Return test suite
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Test minimal configuration serialization
     * 
     * @return void
     */
    public function testMinimalSerilization()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/minimal.xml' );

        // This result should come out of the cache.
        eval( '$cachedXml = ' . var_export( $xml, true ) . ';' );

        $this->assertTrue( $cachedXml instanceof arbitXml );
        $this->assertEquals( $xml, $cachedXml );
    }

    /**
     * Test example configuration serialization
     * 
     * @return void
     */
    public function testExampleSerilization()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/example.xml' );

        // This result should come out of the cache.
        eval( '$cachedXml = ' . var_export( $xml, true ) . ';' );

        $this->assertTrue( $cachedXml instanceof arbitXml );
        $this->assertEquals( $xml, $cachedXml );
    }
}

