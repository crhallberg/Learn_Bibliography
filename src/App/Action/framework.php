<?php
// Require PHP Libraries
//require_once('PEAR.php');

 global $instructions;

// Page Instructions Content
include_once('instructions.inc');

class SettingParams {
	
private instructions;
$this->instructions = $_POST['instructions'];
//$instructions[basename($_SERVER['PHP_SELF'])][$_POST['action']] = $_POST['instructions'];

 if (isset($_POST['instructions'])) {
           $instructions[basename($_SERVER['PHP_SELF'])][$_POST['action']] = $_POST['instructions'];		  
           $str = "<?php\n";
          foreach($instructions as $page => $data) {
           foreach ($data as $action => $instruction) {
            $str .= '$instructions[\'' . $page . '\'][\'' . $action . '\'] = "' . addslashes($instruction) . "\";\n";
          }
         }
         $str .= '?>';
         $fp = fopen('instructions.inc', 'w');
         fwrite($fp, $str);
         fclose($fp);
        }
}
?>
