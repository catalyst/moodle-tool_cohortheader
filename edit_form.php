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
 * Cohorts header - edit_form file
 *
 * @package   tool_cohortheader
 * @copyright 2021 Ant
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once("$CFG->libdir/resourcelib.php");

/**
 * Class cohortheader_form
 *
 * The form for cohortheaders
 *
 * @copyright  2021 Ant
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cohortheader_form extends moodleform {

    /**
     * Form definition.
     */
    public function definition() {

        global $PAGE, $DB, $CFG, $SITE;

        require_once($CFG->dirroot . '/admin/tool/cohortheader/locallib.php');
        $mform =& $this->_form;

        $id = '';
        $name = '';
        $configcohorts = null;
        $additionalhtmlhead = '';
        $additionalhtmltopofbody = '';
        $additionalhtmlfooter = '';

        if (optional_param('id', 0, PARAM_INT)) {
            $id = optional_param('id', 0, PARAM_INT);
            $cohortheader = $DB->get_record('tool_cohort_header', array('id' => $id), '*', MUST_EXIST);
            $cohortheadercohorts = $DB->get_records('tool_cohort_header_cohort', array('cohortheaderid' => $id));

            if (!empty($cohortheadercohorts)) {
                foreach ($cohortheadercohorts as $cohortheadercohort) {
                    $configcohorts[] = $cohortheadercohort->cohortid;
                }
            }

            $name = $cohortheader->name;
            $additionalhtmlhead = $cohortheader->additionalhtmlhead;
            $additionalhtmltopofbody = $cohortheader->additionalhtmltopofbody;
            $additionalhtmlfooter = $cohortheader->additionalhtmlfooter;
        }

        // Drop down header.
        $mform->addElement('header', 'displayinfo', get_string('cohortheader', 'tool_cohortheader'));

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

            $option = [
                'multiple' => true
            ];

            $mform->addElement('autocomplete',
                               'configcohorts',
                                get_string('cohortselector', 'tool_cohortheader'),
                                $allcohorts,
                                $option);

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

    /**
     * Form validation.
     *
     * @param array $data
     * @param array $files
     * @return array $errors
     */
    public function validation($data, $files) {
        global $CFG, $DB;

        $errors = parent::validation($data, $files);

        if (strlen(trim($data['name'])) < 1) {
            $errors['name'] = get_string('errorname', 'tool_cohortheader');
        } else if (empty($data['configcohorts'])) {
            $errors['configcohorts'] = get_string('errorconfigcohort', 'tool_cohortheader');
        }

        return $errors;
    }
}




