<?php
class Importar extends Connection {
    function customer() {
        $file = 'customers.csv';
        $conn = $this->getConn();
        $csv = fopen($file, "r");

        if ($csv !== false) {
            while (($data = fgetcsv($csv, 0, "#")) !== false) {
                $id = $data[0];
                $name = $data[1];
                $query = "UPDATE `customers` SET `customerName` = '$name' WHERE `customerId` = '$id'";
                mysqli_query($this->getConn(), $query);
            }
            fclose($csv);
        }
    }

    function getBrandId($brandName) {
        $conn = $this->getConn();
        $query = "SELECT brandId FROM brands WHERE brandName = '$brandName'";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['brandId'];
        }
        return null;
    }

    public function brandCustomer() {
        $file = 'customers.csv'; 
        $csv = fopen($file, "r");
        
        if ($csv !== false) {
            $conn = $this->getConn();
            while (($data = fgetcsv($csv, 0, "#")) !== false) {
                $customerId = $data[0];
                $brands = explode("|", $data[2]);

                foreach ($brands as $brand) {
                    $brandId = $this->getBrandId($brand);
                    if ($brandId !== null) {
                        $query = "INSERT INTO `brandcustomer` (`customerId`, `brandId`) VALUES ('$customerId', '$brandId')";
                        mysqli_query($conn, $query);
                    } 
                }
            }
            fclose($csv);
        }
    }
}
?>

