<?php
// Include the database configuration file 
require_once '../../admin/config.php';
// Create database connection
$host = DB_HOST; 
$database = DB_NAME;
$username = DB_USER;
$password = DB_PASS;

$db = mysqli_connect ($host, $username, $password ,$database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


// Get images from the database
$query = $db->query("SELECT * FROM images ORDER BY uploaded_on DESC");

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = 'uploads/'.$row["file_name"];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
<?php }
}else{ ?>
    <p>No image(s) found...</p>
<?php } ?>