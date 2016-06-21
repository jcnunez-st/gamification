<?php

class BadgesBoardCtrl
{

   function __construct()
   {
      $this->clientCtrl = new GoogleClientCtrl();
      $this->service = new Google_Service_Sheets($this->clientCtrl->getClient());
   }


   function getBadgesBoard()
   {
      $badgesBoard = $this->generateBadgesBoardStructure();
      $userCtrl = new UserController();
      $userRanking = $userCtrl->getUserRanking();
      for ($u = 0; $u < count($userRanking); ++$u) {
         $user = $userRanking[$u];
         for ($b = 0; $b < count($user->badges); ++$b) {
            $badge = $user->badges[$b];
            $level = UtilsService::getFormattedKey($badge->level);

            for ($c = 0; $c < count($badge->categories); ++$c) {
               $category = UtilsService::getFormattedKey($badge->categories[$c]);
               array_push($badgesBoard->{$level}->{$category}, $user);
            }
         }
      }

      return $badgesBoard;
   }


   private function getCategories()
   {
      $spreadsheetId = $this->clientCtrl->getSpreadSheetId();
      $range = "Categories!A2:B";

      $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);

      return $response->getValues();

   }

   private function getLevels()
   {
      $spreadsheetId = $this->clientCtrl->getSpreadSheetId();
      $range = "Levels!A2:A";

      $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);

      return $response->getValues();
   }

   private function generateBadgesBoardStructure()
   {
      $badgesBoard = new stdClass();
      $levels = $this->getLevels();
      $categories = $this->getCategories();
      $badgesBoard->categories = array_map(function ($a) {
         return UtilsService::getFormattedKey($a[0]);
      }, $categories);
      $badgesBoard->levels = array_map(function ($a) {
         return UtilsService::getFormattedKey($a[0]);
      }, $levels);
      for ($l = 0; $l < count($levels); ++$l) {
         $level = UtilsService::getFormattedKey($levels[$l][0]);
         $badgesBoard->{$level} = new stdClass();
         $badgesBoard->{$level}->categories = array();
         for ($c = 0; $c < count($categories); ++$c) {
            $category = UtilsService::getFormattedKey($categories[$c][0]);
            $badgesBoard->{$level}->{$category} = array();
         }
      }
      return $badgesBoard;
   }

}