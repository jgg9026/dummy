<?php

require_once($CFG->dirroot.'/lib/formslib.php');

class plagiarism_setup_form extends moodleform {

/// Define the form
    function definition () {
        global $CFG;

        $mform =& $this->_form;
        $mform->addElement('checkbox', 'dummy_use', get_string('usedummy', 'plagiarism_dummy'));
        $this->add_action_buttons(true);
    }
}
