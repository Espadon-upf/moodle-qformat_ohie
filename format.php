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
 * CSV format question importer.
 *
 * @package    qformat_ohie
 * @copyright   2021 Giard Kenan <giard.kenan@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/*
 hiuao format - simple format for creating multiple and single choice questions.
 * The format looks like this for simple csv file with minimum columns:
 * questionname, questiontext, A,   B,   C,   D,   Answer 1,    Answer 2
 * Question1, "3, 4, 7, 8, 11, 12, ... What number should come next?",7,10,14,15,D
 *
 *
 * The format looks like this for Extended csv file with extra columns columns:
 * questionname, questiontext, A,   B,   C,   D,   Answer 1,    Answer 2,
   answernumbering, correctfeedback, partiallycorrectfeedback, incorrectfeedback, defaultmark
 * Question1, "3, 4, 7, 8, 11, 12, ... What number should come next?",7,10,14,15,D, ,
   123, Your answer is correct., Your answer is partially correct., Your answer is incorrect., 1
 *
 *
 *  That is,
 *  + first line contains the headers separated with commas
 *  + Next line contains the details of question, each line contain
 *  one question text, four option, and either one or two answers again all separated by commas.
 *  Each line contains all the details regarding the one question ie. question text, options and answer.
 *  You can also download the sample file for your reference.
 *
 * @copyright   2021 Giard Kenan <giard.kenan@hotmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$globals['header'] = true;
class qformat_ohie extends qformat_default {

    public function provide_import() {
        return true;
    }

    public function provide_export() {
        return false;
    }

    /**
     * @return string the file extension (including .) that is normally used for
     * files handled by this plugin.
     */
    public function export_file_extension() {
        return '.csv';
    }

    public function readquestions($lines){
        global $CFG;
        require_once($CFG->libdir . '/csvlib.class.php');
        $questions = array();
        $headers = explode(';', $lines[1]);
        $totalofquestion = 0;
        for ($rownum = 2; $rownum < count($lines); $rownum++){
            $rowdata = str_getcsv($lines[$rownum],";");
            if($rowdata[0] != ''){
                $totalofquestion = $rowdata[0];
            }
        }
        $questioncatégory = explode(';', $lines[0])[1];
        for ($rownum = 2; $rownum < count($lines); $rownum++){
            $rowdata = str_getcsv($lines[$rownum],";");
            if(!empty($rowdata[2])) {
                $columncount = count($rowdata);
                $headerscount = count($headers);
                $question = $this->setquestion($rowdata);
                $question = $this->setessentialpart($question, $questioncatégory, $rowdata, $totalofquestion);
                $questions[] = $question;
            }
            else{
                //alerte
            }
        }
        return $questions;

    }

    protected function text_field($text) {
        return array(
            'text' => htmlspecialchars(trim($text), ENT_NOQUOTES),
            'format' => FORMAT_HTML,
            'files' => array(),
        );
    }

    public function readquestion($lines) {
        // This is no longer needed but might still be called by default.php.
        return;
    }

    private function import_truefalse($rowdata){
        question_bank::get_qtype('truefalse');
        $question = $this->defaultquestion();
        $question->qtype = 'truefalse';
        $rightfeedback = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
        $wrongfeedback = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
        if(strpos($rowdata[8],'T')||strpos($rowdata[8],'t')){
            $question->correctanswer = 1;
            $question->feedbacktrue = $rightfeedback;
            $question->feedbackfalse = $wrongfeedback;
        } else {
            $question->correctanswer = 0;
            $question->feedbacktrue = $wrongfeedback;
            $question->feedbackfalse = $rightfeedback;
        }
        return $question;
    }

    private function import_shortanswer($rowdata){
        question_bank::get_qtype('shortanswer');
        $question = $this->defaultquestion();
        $question->qtype = 'shortanswer';
        $useranswers = array();
        for($i = 8; $i < 15; $i++){
            $useranswers[] = $rowdata[$i];
        }
        foreach($useranswers as $key => $useranswer){
            if ($useranswer != ""){
                $question->answer[$key] = $useranswer;
                $question->fraction[$key] = 1;
                $question->feedback[$key] = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
            }
        }
        return $question;
    }

    private function import_numerical($rowdata){
        question_bank::get_qtype('numerical');
        $question = $this->defaultquestion();
        $question->qtype = 'numerical';
        $answer = $rowdata[8];
        $question->answer[] = $answer;
        $question->fraction[] = 1;
        $question->tolerance[] = $rowdata[7];
        $question->feedback[] = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
        return $question;
    }

    private function import_essay($rowdata){
        question_bank::get_qtype('essay');
        $question = $this->defaultquestion();
        $question->qtype = 'essay';
        $question->responseformat = 'editor';
        $question->responserequired = 1;
        $question->responsefieldlines = 15;
        $question->attachments = 0;
        $question->attachmentsrequired = 0;
        $question->graderinfo = array(
            'text' => '', 'format' => FORMAT_HTML, 'files' => array());
        $question->responsetemplate = array(
            'text' => '', 'format' => FORMAT_HTML);
        $question->maxbytes = 0;
        $question->filetypeslist= null;
        return $question;
    }

    private function import_multichoice_one_right_answer($rowdata){
        question_bank::get_qtype('multichoice');
        $question = $this->defaultquestion();
        $useranswers = $this->getanswers($rowdata);
        $rightanswer = $rowdata[8];
        if($rowdata[6] == ''){
            $userpenality = 0;
        } else{
            $userpenality = $rowdata[6]/100;
        }
        $question->qtype = 'multichoice';
        $question->single = 1;
        $question->penalty = $userpenality;
        $acount = 0;
        foreach ($useranswers as $key => $useranswer){
            $question->answer[$acount] = array('text' => $useranswer, 'format' => FORMAT_HTML, 'files' => array());
            if($key == $rightanswer){
                $question->fraction[$acount] = 1;
            } else {
                $question->fraction[$acount] = -1*$userpenality;
            }
            $question->feedback[$acount] = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
            $acount++;
        }
        return $question;
    }

    private function import_multichoice_multiple_right_answer($rowdata){
        question_bank::get_qtype('multichoice');
        $question = $this->defaultquestion();
        $question->single = 0;
        $question->qtype = 'multichoice';
        $userrightanswers = explode(',',$rowdata[8]);
        $useranswers = $this->getanswers($rowdata);

        if(count($useranswers) < count($userrightanswers)){
            imap_alerts();
        }
        foreach ($userrightanswers as $userrightanswer){
            if(empty($useranswers[$userrightanswer])){
                //eror
            }
        }

        $userfractionrightanswer = 1/count($userrightanswers);
        $userfranctionbadanswer = -1/(count($useranswers)-count($userrightanswers));
        $acount = 0;
        foreach($useranswers as $key => $useranswer){
            $question->answer[$acount] = array('text' => $useranswer, 'format' => FORMAT_HTML, 'files' => array());
            $question->feedback[$acount] = array('text' => '', 'format' => FORMAT_HTML, 'files' => array());
            if(in_array($key,$userrightanswers)){
                $question->fraction[$acount] = $userfractionrightanswer;
            } else{
                $question->fraction[$acount] = $userfranctionbadanswer;
            }
            $acount++;
        }
        return $question;
    }

    private function import_multichoice_all_or_nothing($rowdata){
        question_bank::load_question_definition_classes('multichoiceset');
        $question = $this->defaultquestion();
        $question->qtype = 'multichoiceset';
        $question->shuffleanswers = 1;
        $userrightanswers = explode(',',$rowdata[8]);
        $useranswers = $this->getanswers($rowdata);
        $acount = 0;
        foreach ($useranswers as $key => $useranswer){

            $question->answer[$acount] = array('text' => $useranswer, 'format' => FORMAT_HTML);
            $question->feedback[$acount] = array('text' => '', 'format' => FORMAT_HTML);
            if(in_array($key,$userrightanswers)){
                $question->fraction[$acount] = 1.0;
            }
            else{
                $question->fraction[$acount] = 1.0;
            }
            $acount++;
        }
        return($question);
    }

    private function getanswers($rowdata){
        $key = 'A';
        $answers = array();
        for($i = 9; $i < 15; $i++){
            $curentanswers = $rowdata[$i];
            if(!empty($curentanswers))
                $answers[$key] = $curentanswers;
            $key++;
        }
        return($answers);
    }

    private function setessentialpart($question,$questioncategory, $rowdata, $totalofquestion ){
        //catégorie
        $question->category = $questioncategory;
        //question name
        $question->name = $this->getquestionname($rowdata, $totalofquestion );
        //question text
        $question->questiontext = $rowdata[4];
        $question->questiontextformat = FORMAT_HTML;
        //default mark
        $questionmark = $rowdata[3];
        if($questionmark != 1 ) {
            $question->defaultmark = $questionmark;
        }
        // génnéral feedback
        $question->generalfeedback = $rowdata[5];
        $question->generalfeedbackformat = FORMAT_HTML;
        return $question;
    }

    private function getquestionname($rowdata, $totalofquestion){
        $questionnumber = $rowdata[0];
        if ($rowdata[1] == ""){
            if($totalofquestion<10) {
                return "Question " . $questionnumber;
            } elseif ($totalofquestion<100) {
                if ($questionnumber < 10) {
                    return "Question 0". $questionnumber;
                }
                return "Question ". $questionnumber;
            } else{
                if ($questionnumber < 10) {
                    return "Question 00". $questionnumber;
                } elseif ($questionnumber < 100) {
                    return "Question 0". $questionnumber;
                }
                return "Question ". $questionnumber;
            }
        }
        return($rowdata[1]);
    }

    private function setquestion($rowdata){
        $questiontype = trim($rowdata[2]);
        if ($questiontype == "True/False"){
            $question = $this->import_truefalse($rowdata);
        } elseif ($questiontype == "Short answer"){
            $question = $this->import_shortanswer($rowdata);
        } elseif ($questiontype == "Numerical"){
            $question = $this->import_numerical($rowdata);
        } elseif ($questiontype == "Essay"){
            $question = $this->import_essay($rowdata);
        } elseif ($questiontype == "Multiple Choice one right answer") {
            $question = $this->import_multichoice_one_right_answer($rowdata);
        } elseif ($questiontype == "Multiple Choice all or nothing") {
            $question = $this->import_multichoice_all_or_nothing($rowdata);
        } elseif ($questiontype == "Multiple Choice multiple right answers") {
            $question = $this->import_multichoice_multiple_right_answer($rowdata);
        } else {
            //eror
        }
        return $question;
    }
}
