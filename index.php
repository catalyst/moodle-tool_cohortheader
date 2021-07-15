<?php 

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');

global $DB, $OUTPUT, $PAGE;

require_login();

$context = context_system::instance();

$PAGE->set_url('/admin/tool/cohortheader/edit.php');
$PAGE->set_context($context);
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);

$table = new html_table();
$table->head = array(get_string('name', 'tool_cohortheader'), get_string('edit', 'tool_cohortheader'));

$cohortheaders = tool_cohortheaderspecifichtml_get_all_cohort_header();

if (!empty($cohortheaders))
{
    foreach ($cohortheaders as $cohortheader)
    {
        $params['contextid'] = $context->id;
        $baseurl = new moodle_url('/admin/tool/cohortheader/index.php', $params);
        $urlparams = array('id' => $cohortheader->id, 'returnurl' => $baseurl->out_as_local_url(false));

        $buttons = [
            html_writer::link(
                new moodle_url('/admin/tool/cohortheader/edit.php', $urlparams),
                $OUTPUT->pix_icon('t/edit', get_string('edit')),
                array('title' => get_string('edit'))
            ),
            html_writer::link(
                new moodle_url('/admin/tool/cohortheader/edit.php', $urlparams + array('delete' => 1)),
                $OUTPUT->pix_icon('t/delete', get_string('delete')),
                array('title' => get_string('delete'))
            )
        ];
        
        $line = implode(' ', $buttons);
        $table->data[] = array($cohortheader->name, $line);
    }
}

echo $OUTPUT->header();
echo html_writer::table($table);
echo $OUTPUT->footer();
