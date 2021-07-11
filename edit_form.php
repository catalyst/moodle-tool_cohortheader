<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
use moodleform;

class cohortheader_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('cohortheader', 'tool_cohortheader'));
        $mform->addElement('text', 'name', 'test2');
        // $mform->addRule('title', null, 'required', null, 'client');
        //$mform->addElement('html','</br>');
        
        $mform->addElement('html', 'test3');
        $mform->setType('displaytexttext', PARAM_RAW);
        //$mform->addRule('displaytext', null, 'required', null, 'client');
        //$mform->addElement('html','</br>');

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
