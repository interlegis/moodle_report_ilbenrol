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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * This file defines the user filter form
 *
 * @package report-ilbenrol
 * @copyrigth 2014 Interlegis (http://www.interlegis.leg.br)
 *
 * @author Sesostris Vieira
 *
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.0.html
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

require_once("$CFG->libdir/formslib.php");
 
class filter_form extends moodleform {
    protected $_courseid;
    protected $_filterfields;

    function filter_form($courseid, $filterfields, $action=null, $customdata=null, $method='get', $target='', $attributes=null, $editable=true) {
        $this->_filterfields = $filterfields;
        $this->_courseid = $courseid;
        parent::moodleform($action, $customdata, $method, $target, $attributes, $editable);
    }

    public function definition() {
        global $CFG;
 
        $mform        = $this->_form; // Don't forget the underscore!
        $courseid     = $this->_courseid;
        $filterfields = $this->_filterfields;

        $mform->addElement('header', 'filter', get_string('filter', 'report_ilbenrol'));

        foreach ($filterfields as $field) {
            $mform->addElement('static', $field->shortname, $field->name, '');
            $options = explode("\n", $field->param1);
            foreach ($options as $option) {
                $mform->addElement('checkbox', "{$field->shortname}[$option]", $option);
            }
        }

        $mform->addElement('submit', 'filterbutton', get_string('applyfilter', 'report_ilbenrol'));
        $mform->addElement('hidden', 'course', $courseid);
    }
}
