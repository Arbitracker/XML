<?php
/**
 * PHP VCS wrapper exceptions
 *
 * This file is part of arbit-wrapper.
 *
 * arbit-wrapper is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation; version 3 of the License.
 *
 * arbit-wrapper is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for
 * more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with arbit-wrapper; if not, write to the Free Software Foundation, Inc., 51
 * Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package VCSWrapper
 * @subpackage Cache
 * @version $Revision: 955 $
 * @license http://www.gnu.org/licenses/lgpl-3.0.txt LGPLv3
 */

namespace Arbit\Xml;

/**
 * Exception thrown, when the assigned value is invalid
 */
class ValueException extends \Exception
{
    /**
     * Construct exception
     *
     * @param string $property
     * @param string $message
     * @return void
     */
    public function __construct( $property, $message )
    {
        parent::__construct( "The value for '$property' is invalid: $message." );
    }
}

