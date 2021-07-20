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
 * Cohorts header - lib file
 *
 * @package   tool_cohortheader
 * @copyright 2021 Ant
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');

/**
 * Add data to head.
 * @return string $line
 */
function tool_cohortheader_before_standard_html_head() {

    $line = '';
    $cohortheaders = tool_cohortheader_get_headers();

    if (!empty($cohortheaders)) {
        foreach ($cohortheaders as $cohortheader) {
            $metaheaders[] = $cohortheader->additionalhtmlhead."\n";
        }
        $line = implode(' ', $metaheaders);
    }

    return $line;
}

/**
 * Add data to footer.
 * @return string $line
 */
function tool_cohortheader_before_footer() {
    global $PAGE;
    $line = '';
    $cohortheaders = tool_cohortheader_get_headers();

    if (!empty($cohortheaders)) {
        foreach ($cohortheaders as $cohortheader) {
            $beforefooter[] = "<div>".$cohortheader->additionalhtmlfooter."</div>\n";
        }

        $line = implode(' ', $beforefooter);
    }

    return $line;
}

/**
 * Add data to top of body.
 * @return string $line
 */
function tool_cohortheader_before_standard_top_of_body_html() {
    $line = '';
    $cohortheaders = tool_cohortheader_get_headers();

    if (!empty($cohortheaders)) {
        foreach ($cohortheaders as $cohortheader) {
            $topofbody[] = "<div>".$cohortheader->additionalhtmltopofbody."</div>\n";
        }

        $line = implode(' ', $topofbody);
    }

    return $line;
}
