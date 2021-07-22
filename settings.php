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
 * Cohorts header - admin configs
 *
 * @package   tool_cohortheader
 * @copyright Catalyst IT 2021
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Add this admin page only if the user has all of the required capabilities.
if ($hassiteconfig) {
    $url = new moodle_url('/admin/tool/cohortheader/edit.php');
    $ADMIN->add('appearance', new admin_externalpage('toolcohortheader',
        get_string('managecohortheaders', 'tool_cohortheader'), $url));
}
