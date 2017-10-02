    <?php 
    class Email {
        private $recipient; //send to email
        private $sender;    // frrom email address
        private $subject;   //content for the subject
        private $message;   //content


        //constructor method goes here
        public function __construct($inRecipient) {
            $this->Recipient = $inRecipient;
        }


        //Sets and Gets
        public function setRecipient ($inRecipient) {
            $this->recipient = $inRecipient;
        }
        public function getRecipient () {
            return $this->recipient;
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

        public function getSubject() {
            return $this->subject;

        }

        public function setMessage ($inMessage) {
            $this->message = $inMessage;
        }

        public function getMessage() {
            return $this->message;

        }

        public function sendMail() {
            $to = $this->getRecipient();
            $subject = $this->getSubject();
            $messageTxt= wordwrap($this->getMessage(), 65,"\n",FALSE);
            $headers = 'From: ' . $this->getSender();

            return mail($to,$subject,$messageTxt,$headers);
        }

    }
    ?>
