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
$string['pluginname_help'] = 'This is a CSV format based on XLSX file for importing questions. Please find the Sample xlsx(sample.xlsx) file sent along with this plugin for your reference.';
$string['pluginname_link'] = 'qformat/ohie';
$string['commma_error'] = '<span style="color: #990000; "> Upload failed. Unnecessary Comma(,) found in <b> Question {$a} </b><br /> Please remove the comma(,) from the field or Put the entire text between the double quotes(" "), So the coomma(,) between them can be ignored. <br /></span>';
$string['newline_error'] = '<span style="color: #990000; ">Upload failed. New Line found in <b> Question {$a} . </b> Make sure that entire question with choices and answers are in one line itself.<br /> Please correct this question and try importing again. <br /> No Question has been imported.</span>';
$string['csv_file_error'] = '<span style="color: #990000; ">Upload failed. Something went wrong at line number <b/> {$a} . </b> Make sure you are uploading a valid CSV file.<br /> Please check that, <b> Simple CSV file must have 8 headers/fields and Extended CSV file must have 13 headers/fields in order work.</b><br /> Please correct the error and try importing again. <br /> No Question has been imported.</span>';
$string['samplefile'] = 'SampleFile';
$string['privacy:metadata'] = 'The Ohie format plugin does not store any personal data.';
