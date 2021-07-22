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
 * Cohorts header - edit file
 *
 * @package   tool_cohortheader
 * @copyright Catalyst IT 2021
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

global $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$id        = optional_param('id', 0, PARAM_INT);
$contextid = optional_param('contextid', 0, PARAM_INT);
$delete    = optional_param('delete', 0, PARAM_BOOL);
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$confirm   = optional_param('confirm', 0, PARAM_BOOL);

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$form = new tool_cohortheader\form\edit_form();

if ($id) {
    $cohortheader = $DB->get_record('tool_cohortheader', array('id' => $id), '*', MUST_EXIST);
}

if ($returnurl) {
    $returnurl = new moodle_url($returnurl);
} else {
    $returnurl = new moodle_url('/admin/tool/cohortheader/index.php', array('contextid' => $context->id));
}

// Update or insert cohortheader record.
if ($form->get_data()) {

    $form = $form->get_data();
    $cohortid = $form->cohortheaderid;

    if ($cohortid) {
        tool_cohortheader_update_cohortheader($form);
        redirect($returnurl, get_string('updatesuccess', 'tool_cohortheader'), null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        tool_cohortheader_insert_cohortheader($form);
        redirect($returnurl, get_string('insertsuccess', 'tool_cohortheader'), null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

// Delete record cohortheader record.
if ($delete) {

    $PAGE->url->param('delete', 1);

    if ($confirm && confirm_sesskey()) {
        tool_cohortheader_delete_cohortheader($cohortheader);
        redirect($returnurl);
    }

    $strheading = get_string('deletecohortheader', 'tool_cohortheader');
    $PAGE->navbar->add($strheading);
    $PAGE->set_title($strheading);
    $PAGE->set_heading($strheading);

    echo $OUTPUT->header();
    echo $OUTPUT->heading($strheading);

    $yesurl = new moodle_url('/admin/tool/cohortheader/edit.php',
                            array(
                                    'id' => $id,
                                    'delete' => 1,
                                    'confirm' => 1,
                                    'sesskey' => sesskey(),
                                    'returnurl' => $returnurl->out_as_local_url()
                                ));

    $message = get_string('delconfirm', 'tool_cohortheader');

    echo $OUTPUT->confirm($message, $yesurl, $returnurl);
    echo $OUTPUT->footer();
    die;
}

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
