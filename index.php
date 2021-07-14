<?php 

require_once(__DIR__ . '/../../../config.php');

global $DB, $OUTPUT, $PAGE;

// $id = optional_param('id',0, PARAM_INT);
// $account = $DB->get_record('block_account', array('id'=>$id), '*');

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());

require_login();

$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$table = new html_table();
$table->head = array('Name', 'Edit');
$table->data[] = array('... first row of data goes here ...');
$table->data[] = array('... second row of data goes here ...');

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();
