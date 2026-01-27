<?php
// functions.php
include_once "db.php";

/**
 * Generate unique 10-digit service number
 * @return string
 */
function generateServiceNumber() {
    global $conn;
    do {
        $service = strval(rand(1000000000, 2147483647));
        $check = mysqli_query($conn, "SELECT service_number FROM users WHERE service_number='$service'");
    } while (mysqli_num_rows($check) > 0);
    return $service;
}

/**
 * Calculate bill based on previous & current readings
 * @param int $previous
 * @param int $current
 * @return array('units'=>int,'total'=>float)
 */
function calculateBill($previous, $current) {
    $units = $current - $previous;
    $total = 0;
    $remaining = $units;

    if ($remaining > 0) {
        $first = min($remaining,50); $total += $first*1.5; $remaining -= $first;
        if($remaining>0){ $second=min($remaining,50); $total+=$second*2.5; $remaining-=$second; }
        if($remaining>0){ $third=min($remaining,50); $total+=$third*3.5; $remaining-=$third; }
        if($remaining>0){ $total += $remaining*4.5; }
    } else { $total = MINIMUM_CHARGE; }

    return ['units'=>$units, 'total'=>$total];
}

/**
 * Get latest bill for a service number
 * @param string $service_number
 * @return array|null
 */
function getLatestBill($service_number){
    global $conn;
    $sql = "SELECT b.*, u.name AS username, u.address, u.phone, u.pin,
            m.previous_reading, m.current_reading
            FROM bills b
            JOIN users u ON u.service_number = b.service_number
            JOIN meter_readings m ON b.meter_reading_id = m.id
            WHERE b.service_number='$service_number'
            ORDER BY CASE WHEN b.status='UNPAID' THEN 0 ELSE 1 END, b.bill_date DESC, b.id DESC
            LIMIT 1";
    $res = mysqli_query($conn,$sql);
    return mysqli_fetch_assoc($res);
}

/**
 * Get pending amount for a service number
 * @param string $service_number
 * @param string|null $exclude_bill_number
 * @return float
 */
function getPendingAmount($service_number,$exclude_bill_number=null){
    global $conn;
    $sql = "SELECT IFNULL(SUM(total),0) AS pending_total FROM bills
            WHERE service_number='$service_number' AND status='UNPAID'";
    if($exclude_bill_number) $sql .= " AND bill_number!='$exclude_bill_number'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);
    return $row['pending_total'] ?? 0;
}

/**
 * Mark bill as paid
 * @param string $bill_number
 * @return bool
 */
function markBillPaid($bill_number){
    global $conn;
    $update = mysqli_query($conn,"UPDATE bills SET status='PAID' WHERE bill_number='$bill_number'");
    return $update && mysqli_affected_rows($conn)>0;
}
