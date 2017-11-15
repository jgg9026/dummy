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


require_once(dirname(dirname(__FILE__)) . '/../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/plagiarismlib.php');
require_once($CFG->dirroot.'/plagiarism/dummy/lib.php');
require_once($CFG->dirroot.'/plagiarism/dummy/plagiarism_form.php');
global $CFG;
require_login();
admin_externalpage_setup('plagiarismdummy');
$context = context_system::instance();

require_capability('moodle/site:config', $context, $USER->id, true, "nopermissions");

$mform = new plagiarism_setup_form();
$plagiarismplugin = new plagiarism_plugin_dummy();
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/plagiarism/dummy/settings.php'));
}

echo $OUTPUT->header();

if (($data = $mform->get_data()) && confirm_sesskey()) {
    if (!isset($data->dummy_use)) {
        $data->dummy_use = 0;
    }
    foreach ($data as $field => $value) {
        if (strpos($field, 'dummy') === 0) {
            if ($field == 'dummy_use') {
                set_config($field, $value, 'plagiarism');
            }
        }
    }
    echo $OUTPUT->notification(get_string('savedconfigsuccess', 'plagiarism_dummy'), \core\output\notification::NOTIFY_SUCCESS);
}

$plagiarismsettings = (array)get_config('plagiarism_dummy');
$mform->set_data($plagiarismsettings);

echo $OUTPUT->box_start('generalbox boxaligncenter', 'intro');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();