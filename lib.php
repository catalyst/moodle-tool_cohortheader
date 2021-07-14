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

function tool_cohortheader_get_headers() {

    global $USER;
    static $headers = null;

    if (is_null($headers)) {
        $sql = "
                SELECT ch.* 
                FROM {tool_cohort_header} ch 
                JOIN {tool_cohort_header_cohort} chc ON chc.cohortheaderid = ch.id and chc.cohortid IN (SELECT c.*
                                                                                          FROM {cohort} c
                                                                                          JOIN {cohort_members} cm ON c.id = cm.cohortid
                                                                                          WHERE cm.userid = :userid AND c.visible = 1)";
        $headers = $DB->get_records_sql($sql, ['userid'] => $USER->id);
    }

    return $headers;
}