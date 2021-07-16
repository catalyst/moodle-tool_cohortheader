<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once("$CFG->libdir/resourcelib.php");

class cohortheader_form extends moodleform {
 
    function definition() {

        global $PAGE, $DB, $CFG, $SITE;

        require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');
        $mform =& $this->_form;

        $id = '';
        $name = '';
        $configcohorts = '';
        $additionalhtmlhead = '';
        $additionalhtmltopofbody = '';
        $additionalhtmlfooter = '';

        if(optional_param('id', 0, PARAM_INT)) {
            $id = optional_param('id', 0, PARAM_INT);
            $cohortheader = $DB->get_record('tool_cohort_header', array('id' => $id), '*', MUST_EXIST);
            $cohortheadercohort = $DB->get_record('tool_cohort_header_cohort', array('cohortheaderid' => $id), '*', MUST_EXIST);
            $name = $cohortheader->name;
            $configcohorts = $cohortheadercohort->cohortid;
            $additionalhtmlhead = $cohortheader->additionalhtmlhead;
            $additionalhtmltopofbody = $cohortheader->additionalhtmltopofbody;
            $additionalhtmlfooter = $cohortheader->additionalhtmlfooter;
        }

        // Drop down header.
        $mform->addElement('header','displayinfo', get_string('cohortheader', 'tool_cohortheader'));

        // Refers to the id of the tool_cohort_header record.
        $mform->addElement('hidden', 'cohortheaderid'); 
        $mform->setType('cohortheaderid', PARAM_INT);
        $mform->setDefault('cohortheaderid', $id);

        // Allows the admin to give this item a name to help them idendify it.
        $mform->addElement('text', 'name', get_string('name', 'tool_cohortheader'));
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', $name);

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
            $mform->setDefault('configcohorts', $configcohorts);
        }

        $mform->addElement('textarea', 'additionalhtmlhead', get_string('additionalhtmlhead', 'tool_cohortheader'));
        $mform->setType('additionalhtmlhead', PARAM_TEXT);
        $mform->setDefault('additionalhtmlhead', $additionalhtmlhead);

        $mform->addElement('textarea', 'additionalhtmltopofbody', get_string('additionalhtmltopofbody', 'tool_cohortheader'));
        $mform->setType('additionalhtmltopofbody', PARAM_TEXT);
        $mform->setDefault('additionalhtmltopofbody', $additionalhtmltopofbody);

        $mform->addElement('textarea', 'additionalhtmlfooter', get_string('additionalhtmlfooter', 'tool_cohortheader'));
        $mform->setType('additionalhtmlfooter', PARAM_TEXT);
        $mform->setDefault('additionalhtmlfooter', $additionalhtmlfooter);

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
