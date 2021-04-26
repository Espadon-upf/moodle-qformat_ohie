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
class qformat_hiuao extends qformat_default {

    public function provide_import() {
        return true;
    }

    public function provide_export() {
        return true;
    }

    public function readquestion($lines){
        global $CFG;
        require_once($CFG->libdir . '/csvlib.class.php');
        question_bank::get_qtype('multianswer');
        $questions = array();
        $question = $this->defaultquestion();
        $headers = explode(';', $lines[1]);
        $totalofquestion = $lignes[count($lignes)][0];
        $questioncatégory = explode(';', $lines[0])[1];

        for ($rownum = 2; $rownum < count($lines); $rownum++){
            $rowdata = str_getcsv($lignes[$rownum],";");
            if($rowdata[1] != "") {
                $columncount = count($rowdata);
                $headerscount = count($headers);

                setessentialpart($question, $questioncatégory, $rowdata, $rownum, $totalofquestion);
                $this->setquestion($question,$rowdata);
                $questions[] = $question;
            }
            else{
                //alerte
            }
        }

    }
    /**
     * @return string the file extension (including .) that is normally used for
     * files handled by this plugin.
     */
    public function export_file_extension() {
        return '.csv';
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

    private function import_truefalse($question, $rowdata){
        $question->qtype = 'truefalse';
        $question->answer = $rowdata[8];
    }

    private function import_shortanswer($question, $rowdata){
        $question->qtype = 'shortanswer';
        $useranswers = array();
        for($i = 8; $i < 15; $i++){
            $useranswers[] = $rowdata[i];
        }
        $countanswers = 0;

        foreach($useranswers as $useranswer){
            if ($useranswer != ""){
                $question->answer[$countanswers] = $useranswer;
                $question->fraction[$countanswers] = 100;
                $countanswers++;
            }
        }

    }

    private function import_numerical($question, $rowdata){
        $question->qtype = numerical;
        $question->answer = $rowdata[8];
        $usertolerance = $rowdata[7];
        $question->tolerance = $usertolerance;
    }

    private function import_essay($question, $rowdata){
        $question->qtype = 'essay';
    }

    private function import_multichoice_one_right_answer($question, $rowdata){
    $useranswer = $rowdata[$i];
    $rightanswer = $rowdata[8];
    $userpenality = $rowdata[6];
    if($userpenality == '')
        $userpenality = 0;
    $question->qtype = 'multichoice';
    $question->single = 1;
    $question->penalty = $userpenality;
    for($i = 9; $i < 15; $i++){
        if($useranswer != ""){
            $question->answer[] = $useranswer;
            if($useranswer == $rightanswer){
                $question->fraction[] = 100;
            } else{
                $question->fraction[] = (-1 * $userpenality);
            }
        }
    }
    }

    private function import_multichoice_multiple_right_answer($question, $rowdata){
        $question->signgle = 0;
        $question->qtype = multichoice;
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

        $userfractionrightanswer = 100/count($userrightanswers);
        $userfranctionbadanswer = -100/(count($useranswers)-count($userrightanswers));

        foreach($useranswers as $key => $useranswer){
            $question->answer[] = $useranswer;
            if(in_array($key,$userrightanswers)){
                $question->fraction[] = $userfractionrightanswer;
            } else{
                $question->fraction[] = $userfranctionbadanswer;
            }
        }
    }

    private function import_multichoice_all_or_nothing($rowdata){
        $userrightanswers = explode(',',$rowdata[8]);
        $useranswers = $this->getanswers($rowdata);
        $answers = array();
        $numquestion = 1;
        foreach ($useranswers as $key => $unseranswer){
            if(in_array($key,$userrightanswers)){
                $answers[$numquestion] = new question_answer($numquestion,$rowdata[4],1.0,'',FORMAT_HTML);
            }
            else{
                $answers[$numquestion] = new question_answer($numquestion,$rowdata[4],0,'',FORMAT_HTML);
            }
        }
        return($answers);
    }

    private function getanswers($rowdata){
        $key = 'A';
        $answers = array();
        for($i = 9; $i < 15; $i++){
            $curentanswers = $rowdata[i];
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
        //default mark
        $questionmark = $rowdata[3];
        if($questionmark != 1 ) {
            $question->defaultmark = $questionmark;
        }
        // génnéral feedback
        $question->generalfeedback = $rowdata[5];
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

    private function setquestion($question, $rowdata){
        $questiontype = $rowdata[2];
        if ($questiontype == "True/False"){
            $this->import_truefalse($question, $rowdata);
        } elseif ($questiontype == "Short answer"){
            $this->import_shortanswer($question, $rowdata);
        } elseif ($questiontype == "Numerical"){
            $this->import_numerical($question, $rowdata);
        } elseif ($questiontype == "Essay"){
            $this->import_essay($question, $rowdata);
        } elseif ($questiontype == "Multiple Choice one right answer") {
            $this->import_multichoice_one_right_answer($question, $rowdata);
        } elseif ($questiontype == "Multiple Choice all or nothing") {
            question_bank::load_question_definition_classes('multichoiceset');
            $mc = new qtype_multichoiceset_question();
            test_question_maker::initialise_a_question($mc);
            $mc->name = $question->name;
            $mc->questiontext = $question->questiontext;
            $mc->generalfeedback = $question->generalfeedback;
            $mc->qtype = question_bank::get_qtype('multichoiceset');
            $mc->shuffleanswers = 1;
            $mc->answernumbering = 'ABC';
            test_question_maker::set_standard_combined_feedback_fields($mc);
            $mc->answers = $this->import_multichoice_all_or_nothing($rowdata);
            $question = $mc;
        } elseif ($questiontype == "Multiple Choice multiple right answers") {
            $this->import_multichoice_multiple_right_answer($question, $rowdata);
        } else {
            //eror
        }
    }
}
