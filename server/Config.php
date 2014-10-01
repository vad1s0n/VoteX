<?php
/**
 * Created by Vad1s0n
 * Date: 29.09.14
 * Time: 1:18
 * gitHub: https://github.com/vad1s0n/
 * Skype: keltus916
 */

error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT ^ E_WARNING);

class Config {
    const mysql_host = "localhost";
    const mysql_user = "vote";
    const mysql_password = "votepassword";
    const mysql_db = "vote";

    const show_numbers = false;

    static function connect() {
        //open mysql
        mysql_connect(self::mysql_host,self::mysql_user,self::mysql_password);
        mysql_select_db(self::mysql_db);
    }

    static function get_info() {
        $q = mysql_query("SELECT question_id,question_text FROM questions WHERE active_flg>0");
        if(mysql_num_rows($q)>0) {
            $questions = array();
            while($row = mysql_fetch_assoc($q)) {
                if(self::can_vote($row['question_id'])) {
                    $row['answers'] = self::get_answers_text($row['question_id']);
                    $row['type']="vote";
                }else{
                    $row['answers'] = self::get_answers($row['question_id']);
                    $row['type']="results";
                }
                $questions[] = $row;
            }
            return $questions;
        }else{
            return array("error"=>"Currently don't have any questions");
        }
    }

    static function get_answers($id) {
        $q = mysql_query("SELECT answer_id,answer_text,count,color,'number' as type FROM answers WHERE active_flg>0 AND question_id=$id");
        $total = 0;
        if(mysql_num_rows($q)>0) {
            $answers = array();
            while($row = mysql_fetch_assoc($q)) {
                $total += $row['count'];
                $answers[] = $row;
            }

            $step = $total / 100;
            $tmp = 100;
            $i=0;
            $numItems = sizeof($answers);
            foreach($answers as &$row) {
                if(self::show_numbers) {
                    $row['num']=$row['count'];
                    $row['type']="numbers";
                }else{
                    $row['type'] = "percent";
                }
                $row['count'] = round($row['count']/$step);
                if(++$i !== $numItems) {
                    $tmp -= $row['count'];
                }
            }
            if($total>0) {
                $answers[sizeof($answers)-1]['count']=$tmp;
            }
            return $answers;
        }else{
            return array();
        }
    }

    static function get_answers_text($id) {
        $q = mysql_query("SELECT answer_id,answer_text FROM answers WHERE active_flg>0 AND question_id=$id");
        if(mysql_num_rows($q)>0) {
            $answers = array();
            while($row = mysql_fetch_assoc($q)) {
                $answers[] = $row;
            }
            return $answers;
        }else{
            return array();
        }
    }

    static function can_vote($question_id) {
        $ip = getenv("REMOTE_ADDR");
        $q = mysql_query("SELECT * FROM votes WHERE ip='$ip' AND question_id='$question_id'");
        if(mysql_num_rows($q)==0) {
            return true;
        }else{
            return false;
        }
    }

    static function vote($question_id=false,$answer_id=false) {
        if($question_id && $answer_id && intval($question_id) > 0 && intval($answer_id) > 0) {
            $question_id = intval($question_id);
            $answer_id = intval($answer_id);
            if(self::can_vote($question_id)) {
                $ip = getenv("REMOTE_ADDR");
                mysql_query("INSERT INTO votes VALUES (null,$question_id,$answer_id,'$ip',NOW())");
                mysql_query("UPDATE answers SET count=count+1 WHERE answer_id=$answer_id");
                return array("msg"=>"ok");
            }else{
                return array("error"=>"You've already voted");
            }
        }else{
            return array("error"=>"Unexpected error");
        }
    }
}