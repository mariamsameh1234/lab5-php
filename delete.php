session_start();
include 'database.php';

$config = new DatabaseConfig('localhost', 'root', '123456', 'caffe');
$db = new Database($config);
$userdb = new User($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userdb->delete($id); 
}

header("Location: display_users.php");
exit();

