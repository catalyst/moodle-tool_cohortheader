<?php

require_once('../../../config.php');
require_once($CFG->dirroot.'/admin/tool/cohortheader/edit_form.php');

global $DB, $OUTPUT, $PAGE;

// $id = optional_param('id',0, PARAM_INT);
// $account = $DB->get_record('block_account', array('id'=>$id), '*');

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());
require_login();

$PAGE->set_title('blah');
$PAGE->set_heading('blah');


// $PAGE->set_pagelayout('mydashboard');
// $PAGE->set_heading(get_string('edithtml', 'block_account'));

$form = new cohortheader_form();

if ($data = $form->get_data()) {

    global $DB;

    $toolcohortheader = new \stdClass();
    $toolcohortheader->name = $data->name;
    $toolcohortheader->additionalhtmlhead = $data->additionalhtmlhead;
    $toolcohortheader->additionalhtmltopofbody = $data->additionalhtmltopofbody;
    $toolcohortheader->additionalhtmlfooter = $data->additionalhtmlfooter;

    $DB->insert_record('tool_cohort_header', $toolcohortheader);

    $toolcohortheadercohort = new \stdClass();
    $toolcohortheadercohort->cohortheaderid = $form->configcohorts;
    $toolcohortheadercohort->cohortid = $form->configcohorts;

    $DB->insert_record('tool_cohort_header_cohort', $toolcohortheadercohort);

}

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
