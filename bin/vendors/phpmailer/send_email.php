<?php

	class send_email
	{
		
		public $host = 'localhost';
		public $port = 25;
		public $from = false;
		public $from_name = false;
		public $to = false;
		public $html = false;
		public $text = false;
		public $subject = false;
		
		public function run()
		{
		
			if( !$this->html || !$this->to )
			{
				return false;
			}
		
			$mail = new PHPMailer(true);
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = $this->host; // SMTP server
			$mail->Port       = $this->port;
			
			$mail->IsHTML(true);
			
			$mail->AddReplyTo($this->from, $this->from_name);
			$mail->AddAddress($this->to);
			$mail->From 	= $this->from;
			$mail->FromName = $this->from_name;
			$mail->Subject 	= $this->subject;
			$mail->AltBody 	= $this->text;
			$mail->Body 	= $this->html;
			
			if( $mail->Send())
			{
				return true;
			}
			
			return false;

		}
	
	}
	
?>