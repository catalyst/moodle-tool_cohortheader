<?php 

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');

global $DB, $OUTPUT, $PAGE;

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context(context_system::instance());

require_login();

$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$cohortheaders = tool_cohortheaderspecifichtml_get_all_cohort_header();

$table = new html_table();
$table->head = array(get_string('name', 'tool_cohortheader'), get_string('edit', 'tool_cohortheader'));

// $baseurl = new moodle_url('/cohort/index.php', $params);

// if ($editcontrols = cohort_header_edit_controls($context, $baseurl)) {
//     echo $OUTPUT->render($editcontrols);
// }
$params['contextid'] = 1;
$baseurl = new moodle_url('/cohort/index.php', $params);
$urlparams = array('id' => 1, 'returnurl' => $baseurl->out_as_local_url(false));

$buttons[] = html_writer::link(new moodle_url('/cohort/edit.php', $urlparams),
$OUTPUT->pix_icon('t/edit', get_string('edit')),
array('title' => get_string('edit')));

$buttons[] = html_writer::link(new moodle_url('/cohort/edit.php', $urlparams + array('delete' => 1)),
$OUTPUT->pix_icon('t/delete', get_string('delete')),
array('title' => get_string('delete')));

$line = implode(' ', $buttons);

if (!empty($cohortheaders))
{
    foreach ($cohortheaders as $cohortheader)
    {
        $table->data[] = array($cohortheader->name, $line);

    }
}

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();
