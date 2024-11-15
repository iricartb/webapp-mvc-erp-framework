<?php 
class FMail {
    private $sSMTPHost;
    private $nSMTPPort;
    private $bSMTPSecureSSL;
    private $bSMTPSecureTLS;
    private $sUsername;
    private $sPassword;
    private $oPhpMailer;
    
    public static function getUsernameMailHeader($username, $host) {
        if (!strpos($username, '@')) {
            return ($username .  substr(strstr($host, '.'), 1));       
        }
        else return $username;  
    }
    
    public static function getDomainNameFromEmailAddress($sEmailAddress) {
        $returnValue = '';
        
        if (strpos($sEmailAddress, '@')) {
            return (substr(strstr($sEmailAddress, '@'), 1));       
        }
        
        return $returnValue;
    }
    
    function __construct($sSMTPHost, $sUsername, $sPassword, $nSMTPPort = 25, $bSMTPSecureSSL = false, $bSMTPSecureTLS = false, $nTimeout = 30) {
        $this->sSMTPHost = $sSMTPHost;
        $this->nSMTPPort = $nSMTPPort;
        $this->bSMTPSecureSSL = $bSMTPSecureSSL;
        $this->bSMTPSecureTLS = $bSMTPSecureTLS;
        
        $this->setCredentials($sUsername, $sPassword);
        
        $this->createMailObject($nTimeout);
    }
    
    function addAttachment($sAttachmentPath, $sAttachmentName) {
        $this->oPhpMailer->AddAttachment($sAttachmentPath, $sAttachmentName);  
    }
    
    function clearAttachments() { $this->oPhpMailer->ClearAttachments(); }
    
    function send($sFrom, $sTo, $sSubject, $sBody, $bHtml = false, $sFullName = '') {
        $this->oPhpMailer->ClearAddresses();
        $this->oPhpMailer->ClearAllRecipients();
        
        $this->oPhpMailer->SetFrom($sFrom, $sFullName);
 
        $this->oPhpMailer->Subject = $sSubject;  
        $this->oPhpMailer->Body = $sBody; 

        if ($bHtml) $this->oPhpMailer->IsHTML(true);
        else $this->oPhpMailer->IsHTML(false);
        
        $this->oPhpMailer->AddAddress($sTo);

        return ($this->oPhpMailer->Send());
    }
    
    function setCredentials($sUsername, $sPassword) {
        $this->sUsername = $sUsername;
        $this->sPassword = $sPassword;
    }
    
    private function createMailObject($nTimeout) {
        $this->oPhpMailer = new PHPMailer();
        
        $this->oPhpMailer->SMTPOptions = array(
           'ssl'=>array(
              'verify_peer'=>false,
              'verify_peer_name'=>false,
              'allow_self_signed'=>true
            )
        );

        $this->oPhpMailer->Timeout = $nTimeout;
        $this->oPhpMailer->IsSMTP();
                     
        $this->oPhpMailer->Host = $this->sSMTPHost;
        $this->oPhpMailer->Port = $this->nSMTPPort;

        $this->oPhpMailer->SMTPAuth = true;
        $this->oPhpMailer->Username = $this->sUsername;
        $this->oPhpMailer->Password = $this->sPassword;
        
        $this->oPhpMailer->CharSet = 'UTF-8';
        $this->oPhpMailer->Encoding = 'base64';
                
        if ($this->bSMTPSecureSSL) $this->oPhpMailer->SMTPSecure = 'ssl';
        else if ($this->bSMTPSecureTLS) $this->oPhpMailer->SMTPSecure = 'tls';
        else $this->oPhpMailer->SMTPSecure = FString::STRING_EMPTY;
    }
    
    function getUsername() { return $this->sUsername; }
    function getPassword() { return $this->sPassword; }
    function getSMTPHost() { return $this->sSMTPHost; }
    function getSMTPPort() { return $this->nSMTPPort; }
    function isSMTPSecureSSL() { return $this->bSMTPSecureSSL; }
    function isSMTPSecureTLS() { return $this->bSMTPSecureTLS; }
    
    function getMailObject() { return $this->oPhpMailer; }
}
?>