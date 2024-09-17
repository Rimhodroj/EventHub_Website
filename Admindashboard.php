<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json; charset=UTF-8'); 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "connection.php";
include "notifications.php"; 

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['e_name']) && isset($_POST['action'])) {
    $eventName = mysqli_real_escape_string($con, $_POST['e_name']);
    $action = $_POST['action'];
    
    if ($action === '1') {
            
        $fetchImageSql = "SELECT e_image FROM events WHERE e_name = '$eventName'";
        $fetchImageResult = mysqli_query($con, $fetchImageSql);
        $eventImageUrl = '';
        if ($fetchImageResult && $row = mysqli_fetch_assoc($fetchImageResult)) {
            $eventImageUrl = $row['e_image'];
        }
        
        $updateStatusSql = "UPDATE events SET status = '1' WHERE e_name = '$eventName'";
        $updateStatusResult = mysqli_query($con, $updateStatusSql);
        if ($updateStatusResult) {
            try {
                sendEmailNotification($eventName, $eventImageUrl);
                $response['message'] = 'Event status updated successfully and notifications sent';
            } catch (Exception $e) {
                $response['message'] = 'Event status updated but failed to send notifications: ' . $e->getMessage();
            }
        } else {
            $response['message'] = 'Failed to update event status: ' . mysqli_error($con);
        }
    } else {
        $deletePricesSql = "DELETE FROM EventSectionPrices WHERE e_id = (SELECT e_id FROM events WHERE e_name = '$eventName')";
        $deletePricesResult = mysqli_query($con, $deletePricesSql);
        if ($deletePricesResult) {
            $deleteEventSql = "DELETE FROM events WHERE e_name = '$eventName'";
            $deleteEventResult = mysqli_query($con, $deleteEventSql);
            if ($deleteEventResult) {
                $response['message'] = 'Event and associated prices deleted successfully';
            } else {
                $response['message'] = 'Failed to delete event: ' . mysqli_error($con);
            }
        } else {
            $response['message'] = 'Failed to delete event prices: ' . mysqli_error($con);
        }
    }
    echo json_encode($response);
    exit();
}

$sql = "SELECT e_image, e_name, artist_name, e_location, e_date, e_time FROM events WHERE status = '0'";
$result = mysqli_query($con, $sql);
$events = array();
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

$events = array_reverse($events);
echo json_encode($events);

mysqli_close($con);
?>