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
 * Cohorts header - Locallib file
 *
 * @package   tool_cohortheader
 * @copyright Catalyst IT 2021
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();

/**
 * Get all cohorts which exist in Moodle, regardless if there visibility status, context or members.
 *
 * @return array
 */
function tool_cohortheaderspecifichtml_get_all_cohorts() {
    global $DB;

    return $DB->get_records_select('cohort', '', [], 'name', 'id, name, component');
}

/**
 * Get all custom header instances.
 *
 * @return array
 */
function tool_cohortheaderspecifichtml_get_all_cohort_header() {
    global $DB;
    return $DB->get_records_select('tool_cohortheader', '', [], 'name');
}

/**
 * Get the names of the given cohorts.
 * @param array $ids
 *
 * @return array
 */
function tool_cohortheaderspecifichtml_get_cohort_names($ids) {
    global $DB;
    $cohortnames = array();

    if (!empty($ids)) {
        $result = $DB->get_records_list('cohort', 'id', $ids, 'name', 'name');
        foreach ($result as $r) {
            $cohortnames[] = $r->name;
        }
    }

    return $cohortnames;
}


/**
 * Insert cohort header records
 * @param  stdClass $data
 * @return void
 */
function tool_cohortheader_insert_cohortheader($data) {

    global $DB;
    $chortids = $data->configcohorts;

    $toolcohortheader = new \stdClass();
    $toolcohortheader->name = $data->name;
    $toolcohortheader->additionalhtmlhead = $data->additionalhtmlhead;
    $toolcohortheader->additionalhtmltopofbody = $data->additionalhtmltopofbody;
    $toolcohortheader->additionalhtmlfooter = $data->additionalhtmlfooter;

    $recordid = $DB->insert_record('tool_cohortheader', $toolcohortheader, $returnid = true);

    foreach ($chortids as $chortid) {

        $toolcohortheadercohort = new \stdClass();
        $toolcohortheadercohort->cohortheaderid = $recordid;
        $toolcohortheadercohort->cohortid = $chortid;

        $DB->insert_record('tool_cohortheader_cohort', $toolcohortheadercohort);
    }
}

/**
 * Update cohort header records by id.
 * @param  stdClass $data
 * @return void
 */
function tool_cohortheader_update_cohortheader($data) {

    global $DB;

    $chortids = $data->configcohorts;

    $toolcohortheader = new \stdClass();
    $toolcohortheader->id = $data->cohortheaderid;
    $toolcohortheader->name = $data->name;
    $toolcohortheader->additionalhtmlhead = $data->additionalhtmlhead;
    $toolcohortheader->additionalhtmltopofbody = $data->additionalhtmltopofbody;
    $toolcohortheader->additionalhtmlfooter = $data->additionalhtmlfooter;

    $DB->update_record('tool_cohortheader', $toolcohortheader, $returnid = true);

    $toolcohortheadercohortrecord = $DB->get_record('tool_cohortheader_cohort', ['cohortheaderid' => $data->cohortheaderid]);

    foreach ($chortids as $chortid) {

        $toolcohortheadercohort = new \stdClass();
        $toolcohortheadercohort->id = $toolcohortheadercohortrecord->id;
        $toolcohortheadercohort->cohortheaderid = $data->cohortheaderid;
        $toolcohortheadercohort->cohortid = $chortid;

        $DB->update_record('tool_cohortheader_cohort', $toolcohortheadercohort, $bulk = false);
    }

}

/**
 * Delete cohort header records by id.
 * @param  stdClass $cohortheader
 * @return void
 */
function tool_cohortheader_delete_cohortheader($cohortheader) {
    global $DB;

    $DB->delete_records('tool_cohortheader', array('id' => $cohortheader->id));
    $DB->delete_records('tool_cohortheader_cohort', array('cohortheaderid' => $cohortheader->id));
}

/**
 * Get appropriate cohort header info depending on the group the user is in.
 * @return $headers
 */
function tool_cohortheader_get_headers() {

    global $USER, $DB;
    static $headers = null;

    if (is_null($headers)) {

        $sql =
            "SELECT DISTINCT ch.*
            FROM {tool_cohortheader} ch
            JOIN {tool_cohortheader_cohort} chc ON chc.cohortheaderid = ch.id
            LEFT JOIN {cohort_members} cm ON cm.cohortid = chc.cohortid
            WHERE cm.userid = ? IS NOT NULL;";

        $headers = $DB->get_records_sql($sql, array($USER->id));
    }

    return $headers;
}

