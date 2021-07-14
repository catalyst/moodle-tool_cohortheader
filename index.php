<?php 

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');

global $DB, $OUTPUT, $PAGE;

// $id = optional_param('id',0, PARAM_INT);
// $account = $DB->get_record('block_account', array('id'=>$id), '*');

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());

require_login();

$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$cohortheaders = tool_cohortheaderspecifichtml_get_all_cohort_header();

$table = new html_table();
$table->head = array('Name', 'Edit');


if (!empty($cohortheaders))
{
    foreach ($cohortheaders as $cohortheader)
    {
        $table->data[] = array($cohortheader->name, 'edit');

    }
}


// var_dump($table->data);die;

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();
