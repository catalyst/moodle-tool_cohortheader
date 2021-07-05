<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Data provider.
 *
 * @package    tool_cohortheader
 * @copyright  2021 Ant
 * @author     Ant
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_auth\privacy;
defined('MOODLE_INTERNAL') || die();

use context;
use core_privacy\local\metadata\collection;

/**
 * Data provider class.
 *
 * @package    core_auth
 * @copyright  2021 Ant
 * @author     Ant
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\user_preference_provider {

    /**
     * Returns metadata.
     *
     * @param collection 
     * @return collection 
     */
    public static function get_metadata(collection $collection) : collection {

        return $collection;
    }

}


