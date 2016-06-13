<?php

define('APPLICATION_NAME', 'Stratio gamification');
define('CREDENTIALS_PATH', '~/.credentials/stratio-gamification.json');

// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/stratio-gamification.json
define('SCOPES', implode(' ', array(
      Google_Service_Sheets::SPREADSHEETS_READONLY)
));

class GoogleClientCtrl
{
   var $client;

   function getClient()
   {
      $client = new Google_Client();
      $client->setApplicationName(APPLICATION_NAME);
      $client->setScopes(SCOPES);
      $credentials = getenv('CD_CREDENTIALS');
      file_put_contents(getenv("HOMEPATH") . "/client_secret.json", $credentials);
      $client->setAuthConfigFile(getenv("HOMEPATH") . "/client_secret.json");
      $client->setAccessType('offline');

      // Load previously authorized credentials from a file.
      $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
      if (file_exists($credentialsPath)) {
         $accessToken = file_get_contents($credentialsPath);
         $client->setAccessToken($accessToken);

         // Refresh the token if it's expired.
         if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, $client->getAccessToken());
         }
      }

      return $client;
   }

   function generateCredentials()
   {
      if (php_sapi_name() != 'cli') {
         throw new Exception('This application must be run on the command line.');
      }

      $client = $this->getClient();
      // Request authorization from the user.
      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim(fgets(STDIN));

      // Exchange authorization code for an access token.
      $accessToken = $client->authenticate($authCode);

      // Store the credentials to disk.
      $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
      if (!file_exists(dirname($credentialsPath))) {
         mkdir(dirname($credentialsPath), 0700, true);
      }
      file_put_contents($credentialsPath, $accessToken);

      return "Credentials saved to %s\n" . $credentialsPath;
   }

   /**
    * Expands the home directory alias '~' to the full path.
    * @param string $path the path to expand.
    * @return string the expanded path.
    */
   function expandHomeDirectory($path)
   {
      $homeDirectory = getenv('HOME');
      if (empty($homeDirectory)) {
         $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
      }
      return str_replace('~', realpath($homeDirectory), $path);
   }
}