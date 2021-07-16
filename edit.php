<?php

require_once('../../../config.php');
require_once($CFG->dirroot.'/admin/tool/cohortheader/edit_form.php');

global $DB, $OUTPUT, $PAGE;

require_login();
$context = context_system::instance();

$id        = optional_param('id', 0, PARAM_INT);
$contextid = optional_param('contextid', 0, PARAM_INT);
$delete    = optional_param('delete', 0, PARAM_BOOL);
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$confirm   = optional_param('confirm', 0, PARAM_BOOL);

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$form = new cohortheader_form();

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
        cohortheader_update_cohortheader($form);
        redirect($returnurl, get_string('updatesuccess', 'tool_cohortheader'), null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        cohortheader_insert_cohortheader($form);
        redirect($returnurl, get_string('insertsuccess', 'tool_cohortheader'), null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

// Delete record cohortheader record.
if ($delete) {

    $PAGE->url->param('delete', 1);

    if ($confirm && confirm_sesskey()) {
        cohortheader_delete_cohortheader($cohortheader);
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
