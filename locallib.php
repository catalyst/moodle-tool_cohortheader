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
 * @copyright 2021 Ant
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
    return $DB->get_records_select('tool_cohort_header', '', [], 'name');
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
 * Returns navigation controls (tabtree) to be displayed on cohort management pages
 *
 * @param context $context system or category context where cohorts controls are about to be displayed
 * @param moodle_url $currenturl
 * @return null|renderable
 */
function cohort_header_edit_controls(context $context, moodle_url $currenturl) {

    $tabs = array();
    $currenttab = 'view';

    $viewurl = new moodle_url('/cohort/index.php', array('contextid' => $context->id));
    
    if (($searchquery = $currenturl->get_param('search'))) {
        $viewurl->param('search', $searchquery);
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $tabs[] = new tabobject('view', new moodle_url($viewurl, array('showall' => 0)), get_string('systemcohorts', 'cohort'));
        $tabs[] = new tabobject('viewall', new moodle_url($viewurl, array('showall' => 1)), get_string('allcohorts', 'cohort'));
        if ($currenturl->get_param('showall')) {
            $currenttab = 'viewall';
        }
    } else {
        $tabs[] = new tabobject('view', $viewurl, get_string('cohorts', 'cohort'));
    }
    if (has_capability('moodle/cohort:manage', $context)) {
        $addurl = new moodle_url('/cohort/edit.php', array('contextid' => $context->id));
        $tabs[] = new tabobject('addcohort', $addurl, get_string('addcohort', 'cohort'));
        if ($currenturl->get_path() === $addurl->get_path() && !$currenturl->param('id')) {
            $currenttab = 'addcohort';
        }

        $uploadurl = new moodle_url('/cohort/upload.php', array('contextid' => $context->id));
        $tabs[] = new tabobject('uploadcohorts', $uploadurl, get_string('uploadcohorts', 'cohort'));
        if ($currenturl->get_path() === $uploadurl->get_path()) {
            $currenttab = 'uploadcohorts';
        }
    }
    if (count($tabs) > 1) {
        return new tabtree($tabs, $currenttab);
    }
    return null;
}

