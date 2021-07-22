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
 * Cohorts header - index file
 *
 * @package   tool_cohortheader
 * @copyright Catalyst IT 2021
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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

if (!empty($cohortheaders)) {
    foreach ($cohortheaders as $cohortheader) {
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
