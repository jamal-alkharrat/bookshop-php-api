<?php
header("Access-Control-Allow-Origin: https://bookshop-weld.vercel.app");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  // The request is a preflight request. Respond successfully:
  header('Access-Control-Allow-Origin: https://bookshop-weld.vercel.app');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  exit;
}
require_once '../../admin/config.php';

$host = DB_HOST; 
$database = DB_NAME;
$username = DB_USER;
$password = DB_PASS;

$db_link = mysqli_connect ($host, $username, $password ,$database);

// ##########################################################################
// Important: Please request UTF8 based communication, otherwise the JSON export will not work!
// see PHP-Doku: https://www.php.net/manual/de/function.json-encode.php
$db_link->query("SET NAMES 'utf8'"); 
$db_link->query("SET CHARACTER SET utf8");  
$db_link->query("SET SESSION collation_connection = 'utf8_unicode_ci'");
// ##########################################################################
 
$sql = "SELECT * FROM buecher";
 
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg )
{
  die('Invalid request: ' . mysqli_error());
}
$dbdaten = array();   // new array for JSON-export  
 
$showtable = false; // only for tests 
 
if ($showtable)  echo '<table border="1">';

while ($zeile =  $db_erg->fetch_array( MYSQLI_ASSOC ))
{
if ($showtable)
 {echo "<tr>";
  echo "<td>". $zeile['ProductID'] . "</td>";
  echo "<td>". $zeile['Title'] . "</td>";
  echo "</tr>";
  } 
  $dbdaten[] = $zeile; // read DB-Data row by row and build up a new array 
}
if ($showtable) echo "</table>";

// export books as JSON 
$dbdaten_as_json = json_encode($dbdaten);
echo $dbdaten_as_json;

mysqli_free_result( $db_erg );
?>