<?php

define('APPLICATION_NAME', 'Stratio gamification');
define('CREDENTIALS_PATH', '/etc/stratio/gamification/stratio-gamification.json');
define('CLIENT_SECRET_PATH', '/etc/stratio/gamification/client_secret.json');
define('SPREADSHEET_CONFIG', '/etc/stratio/gamification/spreadSheet.json');
define('SHARED_IDS', '/etc/stratio/gamification/shared-ids.json');

// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/stratio-gamification.json
define('SCOPES', implode(' ', array(
      Google_Service_Sheets::SPREADSHEETS_READONLY)
));

class GoogleClientCtrl {
   function __construct() {
      $this->client = null;
      $this->spreadSheetId = null;
   }

   function getClient() {
      if (!$this->client) {
         $this->client = new Google_Client();
         $this->client->setApplicationName(APPLICATION_NAME);
         $this->client->setScopes(SCOPES);
         $this->client->setAuthConfigFile(CLIENT_SECRET_PATH);
         $this->client->setAccessType('offline');

         // Load previously authorized credentials from a file.
         $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
         if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);

            $this->client->setAccessToken($accessToken);

            // Refresh the token if it's expired.
            if ($this->client->isAccessTokenExpired()) {
               $this->client->refreshToken($this->client->getRefreshToken());
               file_put_contents($credentialsPath, $this->client->getAccessToken());
            }
         }
      }
      return $this->client;
   }

   function getSpreadSheetId() {
      if (!$this->spreadSheetId) {
         $string = file_get_contents(SPREADSHEET_CONFIG);
         $spreadSheetConfig = json_decode($string, true);
         $this->spreadSheetId = $spreadSheetConfig['id'];
      }

      return $this->spreadSheetId;
   }

   function getSharedIds() {
      if (!$this->assetsFolder) {
         $string = file_get_contents(SHARED_IDS);
         $sharedIdsJson = json_decode($string, true);
         $this->assetsFolder = $sharedIdsJson['assets'];
      }
   }

   function generateCredentials() {
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
   function expandHomeDirectory($path) {
      $homeDirectory = getenv('HOME');
      if (empty($homeDirectory)) {
         $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
      }
      return str_replace('~', realpath($homeDirectory), $path);
   }
}
