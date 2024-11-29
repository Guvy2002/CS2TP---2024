function openConnect() {
    //put in database ID's to connect to database
    $conn = mysqli_connect(IDs);
    return $conn;
}
function checkConnect ($conn) {
    if(!$conn){
        $connError = "Connection Error: " . mysqli_connection_error();
        return $connError;
    } else {
        $connSuccess = "Connection successful";
        return $ConnSuccess;
    }
}
function closeConnect ($conn) {
    mysqli_close($conn);
}