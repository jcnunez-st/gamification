<?php

class LegendController {

   function __construct() {
      $this->clientCtrl = new GoogleClientCtrl();
      $this->service = new Google_Service_Sheets($this->clientCtrl->getClient());
   }

   function getLegendContent() {
      $spreadsheetId = $this->clientCtrl->getSpreadSheetId();
      $range = "web-legend!A2:I";
      $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
      $legendTable = $response->getValues();
      $legendJson = $this->parseLegend($legendTable);
      return $legendJson;
   }

   private function parseLegend($table) {
      $json = new stdClass();
      if (count($table) > 0) {
         $row = $table[0];
         $json->title = $row[0];
         $json->description = $row[1];
         $json->subtitle = $row[2];
         $json->subdescription = $row[3];
         $json->badges = $this->parseBadges($table);
      }
      return $json;
   }

   private function parseBadges($table) {
      $badges = array();
      for ($i = 0; $i < count($table); ++$i) {
         $row = $table[$i];
         $badge = new stdClass();
         if (count($row) > 7) {
            $badge->id = $row[4];
            $badge->title = $row[5];
            $badge->desc = $row[6];
            $badge->icon = $row[7];
            $badge->img = $row[8];
            array_push($badges, $badge);
         }
      }
      return $badges;
   }
}
