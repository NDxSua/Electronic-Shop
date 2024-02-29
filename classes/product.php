<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../lib/session.php');
?>

<?php
/**
 * 
 */
class product
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getFeaturedProducts()
    {
        $query =
            "SELECT *
			 FROM products
			 WHERE products.status = 1
             order by products.soldCount DESC";
        $result = $this->db->select($query);
        return $result;
    }
}