<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../classes/product.php');
?>


 
<?php
/**
 * 
 */
class cart
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getTotalQtyByUserId()
    {
        $userId = Session::get('userId');
        $query = "SELECT SUM(qty) as total FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
            return $result;
        }
        return false;
    }

    public function get()
    {
        $userId = Session::get('userId');
        $query = "SELECT * FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC);
            return $result;
        }
        return false;
    }

    public function getTotalPriceByUserId()
    {
        $userId = Session::get('userId');
        $query = "SELECT SUM(productPrice*qty) as total FROM cart WHERE userId = '$userId' ";
        $mysqli_result = $this->db->select($query);
        if ($mysqli_result) {
            $result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
            return $result;
        }
        return false;
    }
}