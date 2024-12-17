<?php

class Database {
    private $host = 'localhost';
    private $username = 'Price Verifier';
    private $password = 'Rosalan';
    private $dbname = 'price verifier';
    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }
}

class Item {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function addItem($barcode, $itemName, $description, $price) {
        $result = $this->conn->query("SELECT MAX(id) AS max_id FROM priceitems");
        $row = $result->fetch_assoc();
        $id = $row['max_id'] ? $row['max_id'] + 1 : 1;

        $checkSql = "SELECT * FROM priceitems WHERE id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $checkStmt->close();
            return "<p>Error: Item ID already exists. Please use a unique ID.</p>";
        }

        $sql = "INSERT INTO priceitems (id, barcode, item_name, description, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssd", $id, $barcode, $itemName, $description, $price);

        if ($stmt->execute()) {
            $stmt->close();
            return "<p>Item added successfully!</p>";
        } else {
            $stmt->close();
            return "<p>Error adding item: " . $stmt->error . "</p>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barcode = isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : '';
    $itemName = isset($_POST['item_name']) ? htmlspecialchars($_POST['item_name']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    $price = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : '';

    $db = new Database();
    $conn = $db->connect();
    $item = new Item($conn);

    $result = $item->addItem($barcode, $itemName, $description, $price);

    echo $result;

    $db->close();
}
?>