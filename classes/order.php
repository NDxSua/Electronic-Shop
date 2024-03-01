<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../classes/cart.php');
include_once($filepath . '/../classes/product.php');
?>


 
<?php
/**
 * 
 */
class order
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getOrderByUser()
    {
        $userId = Session::get('userId');
        $query = "SELECT * FROM orders WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC);
            return $result;
        }
        return false;
    }
}