<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dat_ve";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo bảng nếu chưa tồn tại
$sql = "CREATE TABLE IF NOT EXISTS travel_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_type VARCHAR(50) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    departure VARCHAR(255) NOT NULL,
    departure_date DATE NOT NULL,
    return_date DATE
)";

if ($conn->query($sql) === FALSE) {
    die("Lỗi tạo bảng: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tripType = $_POST["trip_type"];
    $destination = $_POST["destination"];
    $departure = $_POST["departure"];
    $departureDate = $_POST["departure_date"];
    $returnDate = isset($_POST["return_date"]) ? $_POST["return_date"] : null;

    echo "Loại Vé " . $tripType . "<br>";
    echo "Điểm Đến: " . $destination . "<br>";
    echo "Điểm Đi: " . $departure . "<br>";
    echo "Ngày Đi: " . $departureDate . "<br>";

    if ($tripType === "round_trip" && $returnDate !== null) {
        echo "Ngày về: " . $returnDate . "<br>";
    }

    // Lưu thông tin vé vào CSDL
    $sql = "INSERT INTO travel_tickets (trip_type, destination, departure, departure_date, return_date)
            VALUES ('$tripType', '$destination', '$departure', '$departureDate', ";

    if ($returnDate !== null) {
        $sql .= "'$returnDate')";
    } else {
        $sql .= "NULL)";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Thông tin vé đã được lưu vào CSDL.";
    } else {
        echo "Lỗi lưu thông tin vé: " . $conn->error;
    }
}
?>
