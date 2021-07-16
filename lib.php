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

$cohortheader = tool_cohortheader_get_headers();

function tool_cohortheader_tool_headtag_before_standard_html_head() {
    return "<meta name='foo' value='before_top_of_body_html' />\n";
}

function tool_cohortheader_tool_mytool_before_footer() {
    global $PAGE;
   $PAGE->requires->js_init_code("alert('before_footer');");
}

function tool_cohortheader_tool_callbacktest_before_standard_top_of_body_html() {
    return "<div style='background: red'>Before standard top of body html</div>";
}