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
 * Version information for the component 'qformat_csv'.
 *
 * @package    qformat_hiuao
 * @copyright  2021 Giard Kenan <giard.kenan@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2021041401;        // The current plugin version (Date: YYYYMMDDXX).
$plugin->maturity  = MATURITY_ALPHA;  // Maturity level.
$plugin->component  = 'qformat_hiuao';  // Plugin name.
$plugin->release  = '3.10.3 (Build: 2020110903)';  // The current module release in human-readable form (x.y).
$plugin->requires = 2015111609;  // Requires Moodle 3.0 or later. But, I think this plugin works with earlier version also.
$plugin->cron     = 0;           // Period for cron to check this module (secs).
