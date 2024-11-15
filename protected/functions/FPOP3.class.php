<?php 
class FPOP3 {
   private $sPOP3Host;
   private $nPOP3Port;
   private $bPOP3SecureSSL;
   private $sUsername;
   private $sPassword;
   private $oImapOpen;

   const POP3_DEFAULT_PORT = 110;
   const POP3_DEFAULT_FOLDER = 'INBOX';
   
   const POP3_DEFAULT_SEARCH = 'ALL';
   const POP3_SEARCH_UNDELETED = 'UNDELETED';
   
   function __construct($sPOP3Host, $sUsername, $sPassword, $nPOP3Port = FPOP3::POP3_DEFAULT_PORT, $bPOP3SecureSSL = false) {
      $this->oImapOpen = null;
    
      $this->sPOP3Host = $sPOP3Host;
      $this->nPOP3Port = $nPOP3Port;
      $this->bPOP3SecureSSL = $bPOP3SecureSSL;
     
      $this->setCredentials($sUsername, $sPassword);
   }

   private function setCredentials($sUsername, $sPassword) {
      $this->sUsername = $sUsername;
      $this->sPassword = $sPassword;
   }
    
   public function openConnection($sFolder = FPOP3::POP3_DEFAULT_FOLDER) {
      $this->closeConnection();

      $sConnectionString = '{' . $this->sPOP3Host . ':' . $this->nPOP3Port . '/pop3'; 
      if ($this->bPOP3SecureSSL) $sConnectionString .= '/ssl/novalidate-cert';
      $sConnectionString .= '}' . $sFolder;
      
      $this->oImapOpen = @imap_open($sConnectionString, $this->sUsername, $this->sPassword);
      
      if ($this->oImapOpen) {
         if (imap_num_msg($this->oImapOpen) == 0) $errors = imap_errors();
         
         return true;   
      }
      else { $errors = imap_errors(); $alerts = imap_alerts(); return false; }
    }
    
    public function getMails($sSearch = FPOP3::POP3_DEFAULT_SEARCH) {
       $oMailsAccount = array();
       
       if ((!is_null($this->oImapOpen)) && ($this->oImapOpen != FALSE)) {
          $oMailsAccount = imap_search($this->oImapOpen, $sSearch);
          
          if ($oMailsAccount) return $oMailsAccount;
          else $oMailsAccount = array();      
       }  
       
       return $oMailsAccount; 
    }
    
    public function closeConnection() {
       if ((!is_null($this->oImapOpen)) && ($this->oImapOpen != FALSE)) {
          @imap_close($this->oImapOpen);
       }      
    }
   
    public function getUsername() { return $this->sUsername; }
    public function getPassword() { return $this->sPassword; }
    public function getPOP3Host() { return $this->sPOP3Host; }
    public function getPOP3Port() { return $this->nPOP3Port; }
    public function isPOP3SecureSSL() { return $this->bPOP3SecureSSL; }
    
    public function getPOP3Object() { return $this->oImapOpen; }
}
?>