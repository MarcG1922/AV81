<?php
require_once 'Conection.php';

class Importar extends Conection {
    
    public function customers($filename) {
        $file = fopen($filename, "r");
        if ($file !== false) {
            $stmt = $this->conn->prepare("INSERT INTO customers (customerId, customerName) VALUES (?, ?)");
            while (($data = fgetcsv($file, 1000, "#")) !== false) {
                $customerId = $data[0];
                $customerName = $data[1];
                $stmt->bind_param("ss", $customerId, $customerName);
                $stmt->execute();
            }
            fclose($file);
            $stmt->close();
        } else {
            echo "Error al abrir el archivo.";
        }
    }

    public function brandCustomer($filename) {
        $file = fopen($filename, "r");
        if ($file !== false) {
            $stmt = $this->conn->prepare("INSERT INTO brandCustomer (customerId, brandId) VALUES (?, ?)");
            while (($data = fgetcsv($file, 1000, "#")) !== false) {
                $customerId = $data[0];
                $brands = explode(", ", $data[2]);
                foreach ($brands as $brand) {
                    $brandId = $this->getBrandId($brand);
                    $stmt->bind_param("si", $customerId, $brandId);
                    $stmt->execute();
                }
            }
            fclose($file);
            $stmt->close();
        } else {
            echo "Error al abrir el archivo.";
        }
    }

    public function getBrandId($brandName) {
        $stmt = $this->conn->prepare("SELECT brandId FROM brands WHERE brandName = ?");
        $stmt->bind_param("s", $brandName);
        $stmt->execute();
        $stmt->bind_result($brandId);
        $stmt->fetch();
        $stmt->close();
        return $brandId;
    }
}

?>
