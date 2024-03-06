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

    public function login($email, $password)
	{
		$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
		$result = $this->db->select($query);
		if ($result) {
			$value = $result->fetch_assoc();
			if ($value['status'] == 0 ) {
				$alert = "Tài khoản bạn đang bị khóa hoặc chưa được xác nhận. Vui lòng liên hệ với ADMIN để được xử lý!";
				return $alert;
			} else {
				Session::set('user', true);
				Session::set('userId', $value['id']);
				Session::set('role_id', $value['role_id']);
				if($value['role_id'] == 1)
				{
					header("Location: ./admin/productlist.php");
				}
				else
				{
					header("Location:index.php");
				}
			}
		} else {
			$alert = "Tên đăng nhập hoặc mật khẩu không đúng!";
			return $alert;
		}
	}

	public function get()
	{
		$userId = Session::get('userId');
		$query = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($this->db->select($query), MYSQLI_ASSOC)[0];
			return $result;
		}
		return false;
	}

	public function update($data)
	{
		$userId = Session::get('userId');
		$fullName = $data['fullName'];
		$email = $data['email'];
		$dob = $data['dob'];
		$address = $data['address'];
		$password = md5($data['password']);

		$query = "UPDATE users SET email = '$email', fullname = '$fullName', dob = '$dob', password = '$password', address = '$address' WHERE id = '$userId' ";
		$result = $this->db->update($query);
		return $result;
	}

	public function getAllAdmin($page = 1, $total = 8)
	{
		if ($page <= 0) {
			$page = 1;
		}
		$tmp = ($page - 1) * $total;
		$query =
			"SELECT users.*, role.name as roleName
			 FROM users INNER JOIN role ON users.role_id = role.id
             limit $tmp,$total";
		$result = $this->db->select($query);
		return $result;
	}

	public function getCountPaging($row = 8)
	{
		$query = "SELECT COUNT(*) FROM users";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$totalrow = intval((mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC)[0])['COUNT(*)']);
			$result = ceil($totalrow / $row);
			return $result;
		}
		return false;
	}

	public function getUserByName($name_u)
	{
		$query =
			"SELECT *
			 FROM users
			 WHERE fullname LIKE '%$name_u%'";
		$mysqli_result = $this->db->select($query);
		if ($mysqli_result) {
			$result = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
			return $result;
		}
		return false;
	}

	public function block($id)
	{
		$query = "UPDATE users SET status = 0 where id = '$id' and role_id = 2 ";
		$result = $this->db->delete($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function active($id)
	{
		$query = "UPDATE users SET status = 1 where id = '$id'  and role_id = 2 ";
		$result = $this->db->delete($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}


}