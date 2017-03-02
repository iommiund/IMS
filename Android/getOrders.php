<?php
include_once "../Setup/Config/config.php";

$query=mysqli_query($con,"SELECT 
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
            ORDER BY 1");

if ($query) {
    while($row=mysqli_fetch_array($query)){
        $flag[] = $row;
    }

    print(json_encode($flag));
}

mysqli_close($con);