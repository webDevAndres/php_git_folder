<?php
class Email {
    private $recipient;     // send to email
    private $recipient2;
    private $sender;        // from email address
    private $subject;       // content for the subject
    private $message;       // content
   


    //constructor method goes here
    public function __construct($inRecipient) {
        $this->recipient = $inRecipient;
    }

    //Sets and Gets

    public function setRecipient ($inRecipient) {
        $this->recipient = $inRecipient;
    }
    public function getRecipient () {
        return $this->recipient;
    }

    
    public function setRecipient2 ($inRecipient2) {
        $this->recipient2 = $inRecipient2;
    }
    public function getRecipient2 () {
        return $this->recipient2;
    }


    public function setSender ($inSender) {
        $this->sender = $inSender;
    }

    public function getSender () {
        return $this->sender;
    }

    public function setSubject ($inSubject) {
        $this->subject = $inSubject;
    }

    public function getSubject () {
        return $this->subject;
    }

    public function setCheckbox ($inCheckbox) {
        $this->checkbox = $inCheckbox;
    }

    public function getCheckbox ($inCheckbox) {
        return $this->checkbox;
    }

    public function setMessage ($inMessage){
        $this->message = $inMessage;
    }

    public function getMessage () {
        return $this->message;
    }
    

    public function sendCustomerMail() {
    
        $to = $this->getRecipient();
        $subject = $this->getSubject();
        $messageTxt = wordwrap($this->getMessage(),65,"\n",FALSE);
        $headers = 'From: ' . $this->getSender();
        return mail($to,$subject,$messageTxt,$headers);
    }

    public function sendClientMail() {
        
            $to = $this->getRecipient2();
            $subject = $this->getSubject();
            $messageTxt = wordwrap($this->getMessage(),65,"\n",FALSE);
            $headers = 'From: ' . $this->getSender();
            return mail($to,$subject,$messageTxt,$headers);
        }


}

?>