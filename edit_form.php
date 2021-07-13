<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once("$CFG->libdir/resourcelib.php");

class cohortheader_form extends moodleform {
 
    function definition() {

        global $PAGE, $DB, $CFG, $SITE;

        require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');

        $context = context_system::instance();
        $PAGE->set_url($CFG->wwwroot.'/admin/tool/cohortheader/edit.php');
        $PAGE->set_context($context);
        $PAGE->set_title($SITE->fullname);
        $PAGE->set_heading($SITE->fullname);
                
        require_login();
        $mform =& $this->_form;

        // Drop down header.
        $mform->addElement('header','displayinfo', get_string('cohortheader', 'tool_cohortheader'));

        // Refers to the id of the tool_cohort_header record.
        $mform->addElement('hidden', 'id'); 
        $mform->setType('id', PARAM_INT);

        // Allows the admin to give this item a name to help them idendify it.
        $mform->addElement('text', 'name', get_string('name', 'tool_cohortheader'));
        $mform->setType('name', PARAM_TEXT);

        // Get all cohorts.
        $allcohorts = tool_cohortheaderspecifichtml_get_all_cohorts();

        if (!empty($allcohorts)) {

            // Transform object to array.
            foreach ($allcohorts as $c) {
                $allcohorts[$c->id] = format_string($c->name);
            }

            $options = array(                                                                                                           
                'multiple' => true                                                 
            );         

            $mform->addElement('autocomplete', 'configcohorts', get_string('cohortselector', 'tool_cohortheader'), $allcohorts, $options);
        }

        $mform->addElement('textarea', 'additionalhtmlhead', get_string('additionalhtmlhead', 'tool_cohortheader'));
        $mform->setType('additionalhtmlhead', PARAM_TEXT);

        $mform->addElement('textarea', 'additionalhtmltopofbody', get_string('additionalhtmltopofbody', 'tool_cohortheader'));
        $mform->setType('additionalhtmltopofbody', PARAM_TEXT);

        $mform->addElement('textarea', 'additionalhtmlfooter', get_string('additionalhtmlfooter', 'tool_cohortheader'));
        $mform->setType('additionalhtmlfooter', PARAM_TEXT);

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
