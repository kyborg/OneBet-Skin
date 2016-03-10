<?php
/*
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace Longman\TelegramBot\Commands;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Command;
use Longman\TelegramBot\Entities\Update;
class ReportCommand extends Command
{
    protected $name = 'report';
    protected $description = 'Report';
    protected $usage = '/report';
    protected $version = '1.0.0';
    protected $enabled = true;
    protected $public = true;
    private function getReport($login,$time)
    {
        $idents = explode(" ", $login);
        $url = 'http://ag.panda8.co/api?action=confirmAgent&agentID='.trim($idents[0]).'&password='.trim($idents[1]).'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int';

        $ch = curl_init();
        $curlConfig = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIESESSION => true);

        #session_write_close();
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception($http_code);
        }
        curl_close($ch);
                $pattern = "#Set-Cookie: (.*?; path=.*?;.*?)\n#";
                preg_match_all($pattern, $response, $matches);
                array_shift($matches);
                $cookie = implode("\n", $matches[0]);
                // read reports
        $url = 'http://ag.panda8.co/api?action=report&agentID='.trim($idents[0]).'&time='.$time.'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int';

        $ch = curl_init();
        $curlConfig = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIESESSION => $cookie);
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception($http_code);
        }
        curl_close($ch);
        return $response;
    }
    private function checkReport($login,$time)
    {
        if (empty($login)) {
            return false;
        }
        // try/catch
               $data = $this->getReport($login,$time);
        $decode = json_decode($data, true);
                $json_a = json_decode($data, true);
		$head_count=0;
		$win_amount=0;
                foreach ($json_a as $Key => $value) {
                         $response.='Account ID: - '. $value['accountID']." -\n".'Turn Over: '. number_format($value['turnOver'],2,'.',',') ."\n";
			 if ($value['playersWin'] <=0)
				$win_text='👍🏻';
			 else
				$win_text='👎';
			 $response.='Win/Lose: '. $win_text .' '. number_format($value['playersWin'],2,'.',',')."\nHead Count: ". $value['memsAction']."\n ...................\n\n";
                	$head_count+=$value['memsAction'];
			$win_amount+=$value['playersWin'];
		}
		$response.="⚽️🏀🏈⚾️🎾🏉\nAgent Balance: ". number_format($win_amount,2,'.',',')."\nTotal Active Players: ".$head_count;
        if (empty($decode)) {
            return false;
        }
        $status = $decode['status'];
        switch (strtolower($status)) {
            case 'true':
                $conditions.= 'Login Ok';
                break;
            case 'false':
                $conditions.= 'Login Failed';
                break;
        }
        return $response;
    } 
    public function execute()
    {

			
        $update = $this->getUpdate();
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $message_id = $message->getMessageId();
	$text = $message->getText(true);
	$cookie=$this->telegram->authorizeUser($message);
		if ($cookie == false)
			$text=$cookie."You Need to Login ";
		else{
			$time='';
        		switch ($text) {
            		case 'today':
                		$time ='Today';
                		 break;			
         		   case 'yesterday':
                		$time ='Yesterday';
                		break;
	           	   case 'this week':
               			 $time ='ThisWeek';
               			 break;
            		   case 'last week':
                	         $time ='LastWeek';
                		 break;
			default:
				$text='Please use following command: /report today | /report yesterday | /report this week | /report last week';
				break;
        }
			if (!empty($time)){
				$user = $this->telegram->getUser($message);
				$text=$this->checkReport($user['agent_id'].' '.$user['agent_password'],$time);
			}
		}
        $data = array();
        $data['chat_id'] = $chat_id;
        $data['reply_to_message_id'] = $message_id;
        $data['text'] = $text;
        $result = Request::sendMessage($data);
        return $result;
    }
}


<?php
/*
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace Longman\TelegramBot\Commands;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Command;
use Longman\TelegramBot\Entities\Update;
class ReportCommand extends Command
{
    protected $name = 'report';
    protected $description = 'Report';
    protected $usage = '/report';
    protected $version = '1.0.0';
    protected $enabled = true;
    protected $public = true;
    private function getReport($login,$time)
    {
        $idents = explode(" ", $login);
        $url = 'http://ag.panda8.co/api?action=confirmAgent&agentID='.trim($idents[0]).'&password='.trim($idents[1]).'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int';

        $ch = curl_init();
        $curlConfig = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIESESSION => true);

        #session_write_close();
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception($http_code);
        }
        curl_close($ch);
                $pattern = "#Set-Cookie: (.*?; path=.*?;.*?)\n#";
                preg_match_all($pattern, $response, $matches);
                array_shift($matches);
                $cookie = implode("\n", $matches[0]);
                // read reports
        $url = 'http://ag.panda8.co/api?action=report&agentID='.trim($idents[0]).'&time='.$time.'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int';

        $ch = curl_init();
        $curlConfig = array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIESESSION => $cookie);
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            throw new \Exception($http_code);
        }
        curl_close($ch);
        return $response;
    }
    private function checkReport($login,$time)
    {
        if (empty($login)) {
            return false;
        }
        // try/catch
               $data = $this->getReport($login,$time);
        $decode = json_decode($data, true);
                $json_a = json_decode($data, true);
		$head_count=0;
		$win_amount=0;
                foreach ($json_a as $Key => $value) {
                         $response.='Account ID: - '. $value['accountID']." -\n".'Turn Over: '. number_format($value['turnOver'],2,'.',',') ."\n";
			 if ($value['playersWin'] <=0)
				$win_text='👍🏻';
			 else
				$win_text='👎';
			 $response.='Win/Lose: '. $win_text .' '. number_format($value['playersWin'],2,'.',',')."\nHead Count: ". $value['memsAction']."\n ...................\n\n";
                	$head_count+=$value['memsAction'];
			$win_amount+=$value['playersWin'];
		}
		$response.="⚽️🏀🏈⚾️🎾🏉\nAgent Balance: ". number_format($win_amount,2,'.',',')."\nTotal Active Players: ".$head_count;
        if (empty($decode)) {
            return false;
        }
        $status = $decode['status'];
        switch (strtolower($status)) {
            case 'true':
                $conditions.= 'Login Ok';
                break;
            case 'false':
                $conditions.= 'Login Failed';
                break;
        }
        return $response;
    } 
    public function execute()
    {

			
        $update = $this->getUpdate();
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $message_id = $message->getMessageId();
		$text = $message->getText(true);
		$cookie=$this->telegram->authorizeUser($message);
		if ($cookie == false)
			// to do : Check if user is SA in order to perform 
			$text=$cookie."You Need to Login ";
		else{
				$user = $this->telegram->getUser($message);
				$text=$this->checkReport($user['agent_id'].' '.$user['agent_password'],$time);
			
		}
        $data = array();
        $data['chat_id'] = $chat_id;
        $data['reply_to_message_id'] = $message_id;
        $data['text'] = $text;
        $result = Request::sendMessage($data);
        return $result;
    }
}


