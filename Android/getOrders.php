<?php

//get page number to be displayed
$page = $_GET['page'];

$start = 0;

$limit = 3;

require_once "../Setup/Config/config.php";

//get total number of orders
$total = mysqli_num_rows(mysqli_query($con,"SELECT o.order_id FROM ims.orders o"));

//setting page limit
$page_limit = $total/$limit;

//if page number > than page limit no data to display
if($page<=$page_limit){

    //calculate start for each page
    $start = ($page - 1) * $limit;

    //get orders data in range
    $sql = "SELECT 
                o.order_id,
                ca.customer_account_id,
                CONCAT(ca.customer_name,
                        ' ',
                        ca.customer_surname) AS customerName,
                CONCAT(s.street_name, ', ', t.town_name) AS address,
                tt.transaction_type,
                o.old_resource,
                rt.resource_type,
                o.initiation_timestamp,
                u.username
            FROM
                ims.orders o
                    INNER JOIN
                ims.transaction_types tt ON o.order_type_id = tt.transaction_type_id
                    INNER JOIN
                ims.customer_accounts ca ON o.customer_id = ca.customer_account_id
                    INNER JOIN
                ims.streets s ON ca.street_id = s.street_id
                    INNER JOIN
                ims.towns t ON ca.town_id = t.town_id
                    INNER JOIN
                ims.resource_types rt ON o.resource_type_id = rt.resource_type_id
                    INNER JOIN
                ims.users u ON o.initiation_uid = u.uid
            WHERE
                o.order_status_id = 2
            ORDER BY 1
            LIMIT $start, $limit";

    //get results
    $results = mysqli_query($con,$sql);

    //add results to array
    $res = array();

    while($row = mysqli_fetch_array($results)){
        array_push($res, array(
            "Order Id" => $row['order_id'],
            "Customer Account Id" => $row['customer_account_id'],
            "Customer Name" => $row['customerName'],
            "Address" => $row['address'],
            "Transaction Type" => $row['transaction_type'],
            "Old Resource" => $row['old_resource'],
            "Resource Type" => $row['resource_type'],
            "Initiation Timestamp" => $row['initiation_timestamp'],
            "Username" => $row['username']
        ));
    }

    //display result in json format
    echo json_encode($res);

} else {
    echo "No results to show";
}
/*
if ($query) {
    while($row=mysqli_fetch_array($query)){
        $flag[] = $row;
    }

    print(json_encode($flag));
}

mysqli_close($con);*/