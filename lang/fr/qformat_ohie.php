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
 * Strings for component 'qformat_ohie', language 'fr'
 *
 * @package    qformat_ohie
 * @copyright  2021 Giard Kenan <giard.kenan@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Format Ohie';
$string['pluginname_help'] = 'Ce plugin permet d\'importer un questionnaire a partir d\'un fichier au format CSV basé 
    sur un second fichier au format XLSX. Veuillez trouver le fichier xlsx (sample.xlsx) envoyé avec ce plugin pour 
    votre référence.';
$string['pluginname_link'] = 'qformat/ohie';
$string['type_error'] = '<span class="text-danger">Échec du téléchargement. Aucun type de question n\'a été trouvé pour <b>la question {$a}. </b><br /> Veuillez définir un type (comme Numérique ou essai) dans le champ. <br /> Veuillez corriger cette question et réessayer d\'importer. <br /> Aucune question n\'a été importée.<br /></span>';
$string['questiontext_error'] = '<span class="text-danger">Échec du téléchargement. Aucun énoncé n\'a été trouvé pour <b>la question {$a}. </b><br /> Assurez-vous que toutes les colonnes de la question essentielle. <br /> Veuillez corriger cette question et réessayer d\'importer. <br /> Aucune question n\'a été importée.<br /></span>';
$string['rightanswer_error'] = '<span class="text-danger">Échec du téléchargement. Aucune bonne réponces n\'a été trouvé pour <b/>la question {$a} . </b><br /> Assurez-vous que toutes les colonnes de la question essentielle. <br /> Veuillez corriger cette question et réessayer d\'importer. <br /> Aucune question n\'a été importée.<br /></span>';
$string['alert_multichoice'] = '<span class="text-warning">Alert ! Nombre incorrect de réponses pour <b>la question {$a} . </b> Nous changeons le type de question en Multiple Choice one right answer.<br /></span>';
$string['samplefile'] = 'SampleFile';
$string['privacy:metadata'] = 'Le plugin Ohie ne stocke pas de données personnelles.';
