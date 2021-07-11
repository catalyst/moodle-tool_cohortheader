<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
use moodleform;

class cohortheader_form extends moodleform {
 
    function definition() {

        global $PAGE;
 
        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('cohortheader', 'tool_cohortheader'));
        $mform->addElement('text', 'name', get_string('name', 'tool_cohortheader'));

        $options = array(
            'multiple' => true
        );

        $mform->addElement('cohort', 'cohorts', get_string('cohortselector', 'tool_cohortheader'), $options);
        
        $mform->setType('displaytexttext', PARAM_RAW);
        $mform->addElement('hidden', 'id');    
        $this->add_action_buttons();
    }
    
    // function validation($data) {
    //     global $CFG, $DB;
    //     $errors = parent::validation($data, $files);
        
    //     $errors= array();
    //     if (!validate_email($data['threshold_email'])) {
    //         $errors['threshold_email'] = get_string('invalidemail');

    //     }
    //     else if ($DB->record_exists('block_account', array('threshold_email'=>$data['threshold_email']))) {        
    //     $errors['threshold_email'] = get_string('emailexists');
    //     }
    //     else if($DB->record_exists('block_account', array('account_code'=>$data['account_code']))){
    //     $errors['account_code'] = get_string('account_code');
    //     }
    //     return $errors;
    // }

}
