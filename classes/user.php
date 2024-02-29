<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
include_once($filepath . '/../lib/database.php');
class user
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();
	}

    public function insert($data)
	{
		$fullName = $data['fullName'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$password = md5($data['password']);


		$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result_check = $this->db->select($check_email);
		if ($result_check) {
			$alert = "Email này đã tồn tại, vui lòng nhập email khác!";
			return $alert;
		} else {

			$query = "INSERT INTO users VALUES (NULL,'$email','$fullName','$dob','$password',2,1,'$address') ";
			$result = $this->db->insert($query);
			if ($result){
				$alert = "Đăng kí thành công!";
				return $alert;
			}	
			else {
				$alert = "Đăng kí thất bại!";
				return $alert;
			}
		}
	}
	public function getLastUserId()
	{
		$query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
			return $result;
		}
		return false;
	}
}