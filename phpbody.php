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

class PriceVerifier {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->connect();
    }

    public function searchItem($barcode, $itemName) {
        $sql = "";
        $stmt = null;

        if (!empty($barcode)) {
            $sql = "SELECT * FROM priceitems WHERE barcode = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $barcode);
        } elseif (!empty($itemName)) {
            $sql = "SELECT * FROM priceitems WHERE item_name LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%" . $itemName . "%";  
            $stmt->bind_param("s", $searchTerm);
        } else {
            return "<p>Please enter an item name or barcode to search.</p>";
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        $output = '<div class="result">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output .= "<br>";
                $output .= "<h1>Item Found!</h1><br>";
                $output .= "<h2>Item Name: " . $row["item_name"] . "<br>";
                $output .= "Barcode: " . $row["barcode"] . "<br>";
                $output .= "Price: $" . $row["price"] . "<br><br>";
            }
        } else {
            $output .= "<h2><p>No item found with the provided criteria.</p></h2>";
        }

        $output .= '</div>';

        $stmt->close();

        return $output;
    }

    public function close() {
        $this->db->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $barcode = isset($_POST['barcode']) ? htmlspecialchars($_POST['barcode']) : '';
    $itemName = isset($_POST['item_name']) ? htmlspecialchars($_POST['item_name']) : '';

    $priceVerifier = new PriceVerifier();
    $result = $priceVerifier->searchItem($barcode, $itemName);

    echo $result;

    $priceVerifier->close();
}
?>