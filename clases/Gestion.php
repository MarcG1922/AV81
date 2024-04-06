<?php
require_once 'Conection.php';

class Gestion extends Conection {
    public function getBrands() {
        $stmt = $this->conn->prepare("SELECT brandId, brandName FROM brands ORDER BY brandName ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            echo "<input type='checkbox' value='" . $row['brandId'] . "' name='" . $row['brandName'] . "'> " . $row['brandName'] . "<br>";
        }
        
        $stmt->close();
    }
}
?>
