<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="manager-container">
        <h1>Order Management</h1>
        <button onclick="window.print()">Print</button>
        
        <div id="order-list">
            <!-- Orders will be listed here -->
        </div>

        <div id="summary">
            <h2>Today's Orders Summary</h2>
            <p id="total-orders">Total Orders Today: 0</p>
            <p id="total-quantity">Total Quantity Sold: 0</p>
        </div>
    </div>

    <script>
        function loadOrders() {
            const orders = JSON.parse(localStorage.getItem('orders')) || [];
            const orderList = document.getElementById('order-list');
            orderList.innerHTML = '';

            let totalOrders = 0;
            let totalQuantity = 0;
            const orderCount = {};

            orders.forEach(order => {
                if (order.status === 'Pending' || order.status === 'Delivered') {
                    const listItem = document.createElement('div');
                    listItem.innerHTML = `
                        <p>Table ${order.table}: ${order.name} - ${order.price} BDT</p>
                        <p>Status: ${order.status}</p>
                    `;
                    orderList.appendChild(listItem);

                    totalOrders++;
                    totalQuantity += 1; // Increment quantity for each order

                    // Count quantities sold
                    if (orderCount[order.name]) {
                        orderCount[order.name]++;
                    } else {
                        orderCount[order.name] = 1;
                    }
                }
            });

            // Update total summary
            document.getElementById('total-orders').innerText = `Total Orders Today: ${totalOrders}`;
            document.getElementById('total-quantity').innerText = `Total Quantity Sold: ${totalQuantity}`;

            // Display quantities sold for each product
            for (const product in orderCount) {
                const soldItem = document.createElement('p');
                soldItem.innerText = `${product}: ${orderCount[product]} sold`;
                orderList.appendChild(soldItem);
            }
        }

        // Load orders on page load
        window.onload = loadOrders;
    </script>
</body>
</html>
