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
 * Strings for component 'qformat_ohie', language 'en'
 *
 * @package    qformat_ohie
 * @copyright  2021 Giard Kenan <giard.kenan@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Ohie format';
$string['pluginname_help'] = 'This is a CSV format based on XLSX file for importing questions. 
    Please find the Sample xlsx(sample.xlsx) file sent along with this plugin for your reference.';
$string['pluginname_link'] = 'qformat/ohie';
$string['type_error'] = '<span class="text-danger">Upload failed. No type set found in <b> Question {$a} . </b><br /> Please set a type (like Numerical or essay) in the field.<br /> Please correct this question and try importing again. <br /> No Question has been imported.<br /></span>';
$string['questiontext_error'] = '<span class="text-danger">Upload failed. No question text found in <b> Question {$a} . </b><br /> Make sure that entire essential question columns.<br /> Please correct this question and try importing again. <br /> No Question has been imported.<br /></span>';
$string['rightanswer_error'] = '<span class="text-danger">Upload failed. No right answer found in <b> Question {$a} . </b><br /> Make sure that entire essential question columns.<br /> Please correct this question and try importing again. <br /> No Question has been imported.<br /></span>';
$string['alert_multichoice'] = '<span class="text-warning">Alert ! Incorrect number of answers in <b> Question {$a} . </b> We change the question type to Multiple Choice one right answer.<br /></span>';
$string['samplefile'] = 'SampleFile';
$string['privacy:metadata'] = 'The Ohie format plugin does not store any personal data.';
