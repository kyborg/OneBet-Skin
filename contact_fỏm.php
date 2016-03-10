<?php
add_action( 'wpcf7_before_send_mail', 'wpcf7_add_text_to_mail_body' );

function wpcf7_add_text_to_mail_body($contact_form){
 $form_id = $contact_form->posted_data['_wpcf7'];
	 if ($form_id == 11903): // 123 => Your Form ID.
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://pph186.com/bot.php?key=b6fbc59dea1f5c41551f895886edbee5&msg=New_Lead&agent_id=sa',
		CURLOPT_USERAGENT => 'PPH186'
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
 endif;

}
$submission = WPCF7_Submission::get_instance();
if ( $submission ) {
$formdata = $submission->get_posted_data();
$email = $formdata['your-email'];
$name = $formdata['your-name'];
}
 http://ag.panda8.co/api?action=createAgentPph&seniorId=dem&email=kyborg@gmail.com&numOfUser=2&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int 
https://ag.panda8.co/api?action=createAgentPph&creditAgent=1000&credit=100&currency=USD&masterId=DEMVI&numOfUser=5&email=kyborg@gmail.com&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int
add_action('wpcf7_mail_sent', 'ip_wpcf7_mail_sent');
function ip_wpcf7_mail_sent($wpcf7){
		$submission = WPCF7_Submission::get_instance();
			if ( $submission ) {
				$formdata = $submission->get_posted_data();
				$email = $formdata['your-email'];
				$first_name = $formdata['your-first-name'];
				$last_name = $formdata['your-last-name'];
				$tel = $formdata['your-tel'];
				$plan = $formdata['your-plan'];
			}
			$time = $today = date("F j, Y, g:i a");
        // Open Agent:
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://ag.panda8.co/api?action=createAgentPph&creditAgent=1000&credit=100&currency=USD&masterId=DEMVI&numOfUser=1&email='.$email.'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int',
                CURLOPT_USERAGENT => 'PPH186',
                CURLOPT_FOLLOWLOCATION => 1,
        ));
		$resp = curl_exec($curl);
        $variables = json_decode($resp,true);
        $agent = strtoupper($variables['agentId']);
        $password = $variables['password'];
        curl_close($curl); 
        // Send Info to bot
		$text = urlencode("-- Sign up -- \n".$time."\n"."First Name: ".$first_name."\n"."Last Name: ".$last_name."\n"."Email: ".$email."\n"."Tel: ".$tel."\n"."Plan: ".$plan."\nAgent ID: ".$agent);
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://pph186.com/bot.php?key=b6fbc59dea1f5c41551f895886edbee5&msg='.$text.'&agent_id=sa',
                CURLOPT_USERAGENT => 'PPH186'
        ));
		// Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        $params = array(
   					"first_name" => $first_name,
 					"last_name" => $last_name,
  					"phone_mobile" => $tel,
  					"email1" => $email,
  					"account_name" => $agent,
  					"account_description" => $plan,
  					"campaign_id" => "c78e72d1-bfaa-b060-be8e-56cb258c33e6",
  					"assigned_user_id" => "1",
		);
 		echo httpPost("http://crm.pph186.com/index.php?entryPoint=WebToLeadCapture",$params);
 		$_SESSION["first_name"] = $first_name;
 		$_SESSION["last_name"] = $last_name;
 		$_SESSION["account_name"] = $agent;

       
}
function httpPost($url,$params)
{
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
 
}




        curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://ag.panda8.co/api?action=createAgentPph&creditAgent=1000&credit=100&currency=USD&masterId=DEMVI&numOfUser=1&email='.$email.'&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int',
                CURLOPT_USERAGENT => 'PPH186'
        ));
        $resp = curl_exec($curl);
        $variables = json_decode($resp);
        echo $variables;
        curl_close($curl);
        
https://ag.panda8.co/api?action=createAgentPph&creditAgent=1000&credit=100&currency=USD&masterId=DEMVI&numOfUser=1&email=kyborg@gmail.com&key=BBBAB3NzaC1yc2EAAAABJQAAAIEAhCdDMhGHdaw1uj9MH2xCB4jktwIgm4Al7S8rxvovMJBAuFKkMDd0vW5gpurUAB0PEPkxh6QFoBNazvio7Q03f90tSP9qpJMGwZid9hJEElplW8p43D3DdxXykLays2M8V2viYGLbiXvAbOECzwD4IaviOpylX0PaFznSR4ssXd0Int