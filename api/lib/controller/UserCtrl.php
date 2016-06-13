<?php

class UserController
{
   var $service;

   function __construct()
   {
      $clientCtrl = new GoogleClientCtrl();
      $this->service = new Google_Service_Sheets($clientCtrl->getClient());
   }

   function getUserRanking()
   {
      $spreadsheetId = "1iaukST7nZrJCxKNEIYx0Zy5K5eROzWd6hnugR2mynoo";
      $range = "Leaderboard!A2:E";

      $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
      $userTable = $response->getValues();

      $users = $this->convertToUserJsonArray($userTable);

      // sort users by their coins
      uasort($users, function ($a, $b) {
         return strnatcmp($b->coins, $a->coins);
      });

      $usersArray = array();
      foreach ($users as $user) {
         array_push($usersArray, $user);
      }

      return $usersArray;
   }

   private function convertToUserJsonArray($rows)
   {
      $userJsonArray = array();
      $badges = array();
      $userJson = new stdClass();
      for ($i = 0; $i < count($rows); ++$i) {
         $currentRow = $rows[$i];
         if (count($currentRow) == 5) {
            $userJson = new stdClass();
            $badges = array();
            $userJson->name = $currentRow[0];
            $userJson->lastName = $currentRow[1];
            $badge = new Badge($currentRow[2], $currentRow[3]);
            array_push($badges, $badge);
            $userJson->coins = $currentRow[4];
            array_push($userJsonArray, $userJson);
         } else {
            $badge = new Badge($currentRow[2], $currentRow[3]);
            array_push($badges, $badge);
            if ($i == count($rows) - 1 || count($rows[$i + 1]) == 5) {
               $userJson->badges = $badges;
            }
         }
      }
      return $userJsonArray;
   }
}