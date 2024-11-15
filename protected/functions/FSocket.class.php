<?php

/**
 * Name: FSocket.class.php
 * Version: 1.0
 */       
class FSocket {
   public static function ping($sHostname, $nTimeoutSeconds = 1) {
      /*try {
         $nResult = 0;

         $sPackage = '\x08\x00\x19\x2f\x00\x00\x00\x00\x70\x69\x6e\x67';
         
         $oSocket = socket_create(AF_INET, SOCK_RAW, 1);
         socket_set_option($oSocket, SOL_SOCKET, SO_RCVTIMEO, array('sec'=>$nTimeoutSeconds, 'usec'=>0));
         socket_connect($oSocket, $sHostname, null);

         $oTimestamp = microtime(true);
         socket_send($oSocket, $sPackage, strlen($sPackage), 0);
         if (@socket_read($oSocket, 255)) {        
            $nResult = microtime(true) - $oTimestamp;
         }
         else $nResult = 0;
         
         socket_close($oSocket);          
      } catch(Exception $e) { 
         socket_close($oSocket);
      }
             
      return $nResult;*/
      
      /*
      $output = shell_exec("ping $sHostname -n 1");
       
      if (strpos($output, "TTL")) {
          return true;
      } else {
          return false;
      }*/
      return true;
   }
}
