<?php

class UtilsService
{

   static  function cleanSpecialCharacters($String)
   {
      $String = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $String);
      $String = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $String);
      $String = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $String);
      $String = str_replace(array('í', 'ì', 'î', 'ï'), "i", $String);
      $String = str_replace(array('é', 'è', 'ê', 'ë'), "e", $String);
      $String = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $String);
      $String = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $String);
      $String = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $String);
      $String = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $String);
      $String = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $String);
      $String = str_replace(array('[', '^', '´', '`', '¨', '~', ']'), "", $String);
      $String = str_replace("ç", "c", $String);
      $String = str_replace("Ç", "C", $String);
      $String = str_replace("ñ", "n", $String);
      $String = str_replace("Ñ", "N", $String);
      $String = str_replace("Ý", "Y", $String);
      $String = str_replace("ý", "y", $String);

      $String = str_replace("&aacute;", "a", $String);
      $String = str_replace("&Aacute;", "A", $String);
      $String = str_replace("&eacute;", "e", $String);
      $String = str_replace("&Eacute;", "E", $String);
      $String = str_replace("&iacute;", "i", $String);
      $String = str_replace("&Iacute;", "I", $String);
      $String = str_replace("&oacute;", "o", $String);
      $String = str_replace("&Oacute;", "O", $String);
      $String = str_replace("&uacute;", "u", $String);
      $String = str_replace("&Uacute;", "U", $String);
      return $String;
   }

}

?>