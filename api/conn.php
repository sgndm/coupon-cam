<?PHP

// DATABASE CONNECTION | Remote server
     $hostname = 'localhost';
     $username = 'dinesh_visni';
     $password = 'dv@cc#010318#';
     $database = 'coupon_cam_db';

// DATABASE CONNECTION | Local server
//   $hostname = 'localhost';
//   $username = 'root';
//   $password = '';
//   $database = 'cc_new';

$is_connected = 0; // NOT CONNECTED

try {
    // connection string
    $dbh = new PDO("mysql:host=$hostname;dbname=" . $database, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // connection opened
    $is_connected = 1;
    //echo "Connected !! <br>";

} catch (PDOException $e) {
    echo $e->getMessage();
}
