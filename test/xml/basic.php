<?php
/**
 * Basic test cases for framework
 *
 * @version $Revision$
 * @license GPLv3
 */

/**
 * Tests for the XML handler
 */
class arbitXmlTests extends arbitTestCase
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
     * Test if unknown users are handled correctly
     * 
     * @return void
     */
    public function testUnknownXmlFile()
    {
        try
        {
            $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/not_existing_file.xml.xml' );
            $this->fail( 'Expected arbitNoSuchFileException.' );
        }
        catch( arbitNoSuchFileException $e )
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
            $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/broken_1.xml' );
            $this->fail( 'Expected arbitXmlParserException.' );
        }
        catch( arbitXmlParserException $e )
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
            $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/broken_2.xml' );
            $this->fail( 'Expected arbitXmlParserException.' );
        }
        catch( arbitXmlParserException $e )
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
            $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/broken_3.xml' );
            $this->fail( 'Expected arbitXmlParserException.' );
        }
        catch( arbitXmlParserException $e )
        { /* Expected */ }
    }

    /**
     * Test minimal valid XML file
     * 
     * @return void
     */
    public function testMinimalXmlFile()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/minimal.xml' );

        $this->assertTrue(
            $xml instanceof arbitXml
        );
    }

    /**
     * Test minimal valid XML file
     * 
     * @return void
     */
    public function testMinimalXmlString()
    {
        $xml = arbitXml::loadString( file_get_contents( dirname( __FILE__ ) . '/../data/xml/minimal.xml' ) );

        $this->assertTrue(
            $xml instanceof arbitXml
        );
    }

    /**
     * Test isset methods
     * 
     * @return void
     */
    public function testIssetXmlhildElements()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/example.xml' );

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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/text.xml' );

        $this->assertTrue(
            $xml instanceof arbitXmlNode
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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/attributes.xml' );

        $this->assertTrue(
            $xml->element instanceof arbitXmlNodeList
        );

        $this->assertTrue(
            $xml->element[0] instanceof arbitXmlNode
        );

        $this->assertTrue(
            $xml->element[1] instanceof arbitXmlNode
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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

        $this->assertTrue(
            $xml->section->module instanceof arbitXmlNodeList
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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            $nodeList->property = 'value';
            $this->fail( 'Expected arbitAccessException.' );
        }
        catch ( arbitAccessException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on setting a node list array value
     * 
     * @return void
     */
    public function testSetNodeListArrayValue()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            $nodeList['key'] = 'value';
            $this->fail( 'Expected arbitValueException.' );
        }
        catch ( arbitValueException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on unsetting a node list array value
     * 
     * @return void
     */
    public function testUnSetNodeListArrayValue()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

        try
        {
            $nodeList = $xml->section->module;
            unset( $nodeList[0] );
            $this->fail( 'Expected arbitValueException.' );
        }
        catch ( arbitValueException $e )
        { /* Expected */ }
    }

    /**
     * Test Node list to string conversion
     * 
     * @return void
     */
    public function testNodeListToStringConversion()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/multilevel.xml' );

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
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/minimal.xml' );

        $xml['attribute'] = 'value';
        try
        {
            $xml[12] = 'value';
            $this->fail( 'Expected arbitValueException.' );
        }
        catch ( arbitValueException $e )
        { /* Expected */ }
    }

    /**
     * Test failure on invalid child name
     * 
     * @return void
     */
    public function testInvalidNodeChildName()
    {
        $xml = arbitXml::loadFile( dirname( __FILE__ ) . '/../data/xml/minimal.xml' );

        try
        {
            $xml->__set( 0, $xml );
            $this->fail( 'Expected arbitValueException.' );
        }
        catch ( arbitValueException $e )
        { /* Expected */ }
    }
}
