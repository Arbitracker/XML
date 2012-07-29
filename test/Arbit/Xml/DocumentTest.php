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
 * Tests for the XML handler
 */
class DocumentTests extends TestCase
{
    /**
     * Test if unknown users are handled correctly
     *
     * @return void
     */
    public function testUnknownXmlFile()
    {
        try
        {
            $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/not_existing_file.xml.xml' );
            $this->fail( 'Expected NoSuchFileException.' );
        }
        catch( NoSuchFileException $e )
        { /* Expected */ }
    }

    /**
     * Test XML file with parse errors
     *
     * @return void
     */
    public function testParseErrors1()
    {
        try
        {
            $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/broken_1.xml' );
            $this->fail( 'Expected XmlParserException.' );
        }
        catch( XmlParserException $e )
        { /* Expected */ }
    }

    /**
     * Test XML file with parse errors
     *
     * @return void
     */
    public function testParseErrors2()
    {
        try
        {
            $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/broken_2.xml' );
            $this->fail( 'Expected XmlParserException.' );
        }
        catch( XmlParserException $e )
        { /* Expected */ }
    }

    /**
     * Test XML file with parse errors
     *
     * @return void
     */
    public function testParseErrors3()
    {
        try
        {
            $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/broken_3.xml' );
            $this->fail( 'Expected XmlParserException.' );
        }
        catch( XmlParserException $e )
        { /* Expected */ }
    }

    /**
     * Test minimal valid XML file
     *
     * @return void
     */
    public function testMinimalXmlFile()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/minimal.xml' );

        $this->assertTrue(
            $xml instanceof Document
        );
    }

    /**
     * Test minimal valid XML file
     *
     * @return void
     */
    public function testMinimalXmlString()
    {
        $xml = Document::loadString( file_get_contents( __DIR__ . '/_fixtures/xml/minimal.xml' ) );

        $this->assertTrue(
            $xml instanceof Document
        );
    }

    /**
     * Test isset methods
     *
     * @return void
     */
    public function testIssetXmlhildElements()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/example.xml' );

        $this->assertFalse( isset( $xml->notexistant ) );
        $this->assertFalse( isset( $xml->general->notexistant ) );
        $this->assertTrue( isset( $xml->general ) );
        $this->assertTrue( isset( $xml->general->password ) );
    }

    /**
     * Test XML file with text content
     *
     * @return void
     */
    public function testTextContent()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/text.xml' );

        $this->assertTrue(
            $xml instanceof Node
        );

        $this->assertEquals(
            "\n\tSome text\n\t\n\tMore text\n",
            (string) $xml
        );

        $this->assertEquals(
            "\n\t\tSub text\n\t",
            (string) $xml->sub[0]
        );
    }

    /**
     * Test minimal valid XML file
     *
     * @return void
     */
    public function testXmlWithAttributes()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/attributes.xml' );

        $this->assertTrue(
            $xml->element instanceof NodeList
        );

        $this->assertTrue(
            $xml->element[0] instanceof Node
        );

        $this->assertTrue(
            $xml->element[1] instanceof Node
        );

        $this->assertEquals(
            'value',
            $xml->element[0]['attribute']
        );

        $this->assertEquals(
            'value2',
            $xml->element[1]['attribute']
        );
    }

    /**
     * Test creation of node list from multilevel query
     *
     * @return void
     */
    public function testMultilevelNodeListCreation()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        $this->assertTrue(
            $xml->section->module instanceof NodeList
        );

        $this->assertEquals(
            3,
            count( $xml->section->module )
        );

        $this->assertEquals(
            'mod2',
            $xml->section->module[1]['id']
        );
    }

    /**
     * Test node list iterator
     *
     * @return void
     */
    public function testNodeListIterator()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        $modules = $xml->section->module;

        $ids = array( 'mod1', 'mod2', 'mod3' );

        foreach ( $modules as $nr => $module )
        {
            $this->assertEquals(
                $ids[$nr],
                $module['id']
            );
        }
    }

    /**
     * Test failure on setting a node list property
     *
     * @return void
     */
    public function testSetNodeListProperty()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            $nodeList->property = 'value';
            $this->fail( 'Expected AccessException.' );
        }
        catch ( AccessException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on setting a node list array value
     *
     * @return void
     */
    public function testSetNodeListArrayValue()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            $nodeList['key'] = 'value';
            $this->fail( 'Expected ValueException.' );
        }
        catch ( ValueException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on unsetting a node list array value
     *
     * @return void
     */
    public function testUnSetNodeListArrayValue()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            unset( $nodeList[0] );
            $this->fail( 'Expected ValueException.' );
        }
        catch ( ValueException $e )
        { /* Expected */ }
    }

    /**
     * Test Node list to string conversion
     *
     * @return void
     */
    public function testNodeListToStringConversion()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/multilevel.xml' );

        $nodeList = $xml->section->module;
        $this->assertEquals(
            "Module",
            (string) $nodeList
        );
    }

    /**
     * Test failure on invalid attribute value
     *
     * @return void
     */
    public function testInvalidNodeAttributeValue()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/minimal.xml' );

        $xml['attribute'] = 'value';
        try
        {
            $xml[12] = 'value';
            $this->fail( 'Expected ValueException.' );
        }
        catch ( ValueException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on invalid child name
     *
     * @return void
     */
    public function testInvalidNodeChildName()
    {
        $xml = Document::loadFile( __DIR__ . '/_fixtures/xml/minimal.xml' );

        try
        {
            $xml->__set( 0, $xml );
            $this->fail( 'Expected ValueException.' );
        }
        catch ( ValueException $e )
        { /* Expected */ }
    }
}

