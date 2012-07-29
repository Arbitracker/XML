<?php
/**
 * Basic test cases for framework
 *
 * @version $Revision$
 * @license GPLv3
 */

namespace Arbit\Xml;

require_once 'TestCase.php';

/**
 * Tests for the XML xml serialization
 */
class SerializeTest extends TestCase
{
    /**
     * Test minimal configuration serialization
     *
     * @return void
     */
    public function testMinimalSerilization()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/minimal.xml' );

        // This result should come out of the cache.
        eval( '$cachedXml = ' . var_export( $xml, true ) . ';' );

        $this->assertTrue( $cachedXml instanceof Document );
        $this->assertEquals( $xml, $cachedXml );
    }

    /**
     * Test example configuration serialization
     *
     * @return void
     */
    public function testExampleSerilization()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/example.xml' );

        // This result should come out of the cache.
        eval( '$cachedXml = ' . var_export( $xml, true ) . ';' );

        $this->assertTrue( $cachedXml instanceof Document );
        $this->assertEquals( $xml, $cachedXml );
    }
}

