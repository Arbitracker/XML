<?php
/**
 * vcs main test suite
 *
 * @version $Revision: 926 $
 * @license LGPLv3
 */

/*
 * Set file whitelist for phpunit
 */
define( 'VCS_TEST', __FILE__ );
$files = include ( $base = dirname(  __FILE__ ) . '/../src/classes/' ) . 'autoload.php';
foreach ( $files as $class => $file )
{
    require_once $base . $file;

    if ( strpos( $file, '/external/' ) === false )
    {
        PHPUnit_Util_Filter::addFileToWhitelist( $base . $file );
    }
}

require 'base_test.php';

/**
 * Test suites
 */
require 'xml_suite.php';

/**
* Test suite for vcs
*/
class vcsTestSuite extends PHPUnit_Framework_TestSuite
{
    /**
     * Basic constructor for test suite
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'vcsWrapper - A PHP version control system wrapper' );

        $this->addTestSuite( vcsXmlTestSuite::suite() );
    }

    /**
     * Return test suite
     * 
     * @return prpTestSuite
     */
    public static function suite()
    {
        return new vcsTestSuite( __CLASS__ );
    }
}
