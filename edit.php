<?php

require_once('../../../config.php');
require_once($CFG->dirroot.'/admin/tool/cohortheader/edit_form.php');

global $DB, $OUTPUT, $PAGE;

// $id = optional_param('id',0, PARAM_INT);
// $account = $DB->get_record('block_account', array('id'=>$id), '*');

$PAGE->set_url('/admin/tool/cohortheader/edit.php');

// $PAGE->set_pagelayout('mydashboard');
// $PAGE->set_heading(get_string('edithtml', 'block_account'));

$accountform = new cohortheader_form();
// $accountform->set_data($account);

// if($accountform->is_cancelled()) {
//     // Cancelled forms redirect to the course main page.
//     $myurl = new moodle_url('/my/');
//     redirect($myurl);
// } else if ($fromform=$accountform->get_data()) {      
//      if (!$DB->update_record('block_account', $fromform)) {
//      print_error('inserterror', 'block_account');
//      }
//     // We need to add code to appropriately act on and store the submitted data
//     // but for now we will just redirect back to the course main page.
//     $thisurl = new moodle_url('editaccount.php?id='.$id);
//     redirect($thisurl);
// }
// else
// {
echo $OUTPUT->header();
$accountform->display();
echo $OUTPUT->footer();
// }
