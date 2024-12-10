<?php
session_start();

// Check if the user is logged in; otherwise, set username as Guest
if (!isset($_SESSION['username'])) {
    $username = 'Guest';
} else {
    $username = $_SESSION['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="container">
        <!-- Welcome Message -->
        <h3 style="color: white;">Welcome to Green Cafe, Guest</h3>

        <!-- Table Number Input Section -->
        <div id="table-section">
            <label for="table-number">Enter your table number:</label>
            <input type="number" id="table-number" placeholder="Table Number" required>
            <button id="start-order">Start Order</button>
        </div>

        <!-- Menu and Order Section -->
        <div id="order-section" style="display: none;">
            <h2>Students Menu Item</h2>
            <div id="menu-items">
                <!-- Menu items will be added dynamically -->
            </div>
            <div id="order-summary">
                <h2>Order Summary</h2>
                <ul id="order-list"></ul>
                <button id="place-order">Place Order</button>
            </div>
        </div>

        <!-- Order Management Section -->
        <div id="order-management" style="display: none;">
            <h2>Order Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Table Number</th>
                        <th>Order Items</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody id="order-management-body">
                    <!-- Orders will be displayed here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let orderSummary = [];

        // Start Order Button
        document.getElementById('start-order').onclick = function() {
            const tableNumber = document.getElementById("table-number").value;
            if (tableNumber) {
                document.getElementById("table-section").style.display = "none";
                document.getElementById("order-section").style.display = "block";
                displayMenu();
            } else {
                alert("Please enter a valid table number.");
            }
        };

        // Display menu items
        function displayMenu() {
            const menuItems = [
                { name: "Burger", price: 100 },
                { name: "Pizza", price: 200 },
                { name: "Pasta", price: 50 },
            ];

            const menuContainer = document.getElementById('menu-items');
            menuContainer.innerHTML = ''; // Clear previous items

            menuItems.forEach(item => {
                const menuItem = document.createElement('div');
                menuItem.classList.add('menu-item');
                menuItem.innerHTML = `
                    <h3>${item.name}</h3>
                    <p>Price: ${item.price} BDT</p>
                    <button onclick="addToOrder('${item.name}', ${item.price})">Add to Order</button>
                `;
                menuContainer.appendChild(menuItem);
            });
        }

        // Add to order
        window.addToOrder = function(name, price) {
            const orderIndex = orderSummary.findIndex(order => order.name === name);
            if (orderIndex !== -1) {
                orderSummary[orderIndex].quantity += 1;
            } else {
                orderSummary.push({ name, price, quantity: 1 });
            }
            renderOrderList();
        };

        // Render order list
        function renderOrderList() {
            const orderList = document.getElementById('order-list');
            orderList.innerHTML = '';
            orderSummary.forEach(order => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${order.name} - ${order.price} BDT x ${order.quantity}
                    <button onclick="decreaseQuantity('${order.name}')">-</button>
                    <button onclick="increaseQuantity('${order.name}')">+</button>
                `;
                orderList.appendChild(listItem);
            });
        }

        // Increase quantity
        window.increaseQuantity = function(name) {
            const order = orderSummary.find(order => order.name === name);
            if (order) {
                order.quantity += 1;
                renderOrderList();
            }
        };

        // Decrease quantity
        window.decreaseQuantity = function(name) {
            const order = orderSummary.find(order => order.name === name);
            if (order && order.quantity > 1) {
                order.quantity -= 1;
                renderOrderList();
            } else if (order.quantity === 1) {
                orderSummary = orderSummary.filter(order => order.name !== name);
                renderOrderList();
            }
        };

        // Place Order
        document.getElementById("place-order").onclick = function() {
            if (orderSummary.length > 0) {
                const tableNumber = document.getElementById("table-number").value;

                // Store the order in the order management section
                const orderItems = orderSummary.map(item => `${item.name} (x${item.quantity})`).join(', ');
                const paymentStatus = "Pending";

                const orderRow = document.createElement('tr');
                orderRow.innerHTML = `
                    <td>${tableNumber}</td>
                    <td>${orderItems}</td>
                    <td>${paymentStatus}</td>
                `;
                document.getElementById('order-management-body').appendChild(orderRow);

                alert("Order placed successfully!");

                // Optionally, clear the order summary
                orderSummary = [];
                renderOrderList();

                // Display order management section
                document.getElementById("order-management").style.display = "block";
            } else {
                alert("Please add items to your order before placing an order.");
            }
        };
    </script>
</body>
</html>
