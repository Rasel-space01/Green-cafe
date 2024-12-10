// Load order from localStorage and display it in payment page
function loadOrder() {
    const order = JSON.parse(localStorage.getItem("order")) || [];
    const orderList = document.getElementById("order-list");
    let totalAmount = 0;

    if (orderList) {
        order.forEach(item => {
            const listItem = document.createElement("li");
            listItem.textContent = `${item.name} - ${item.price} BDT`;
            orderList.appendChild(listItem);
            totalAmount += item.price;
        });

        // Display total amount
        if (document.getElementById("total-amount")) {
            document.getElementById("total-amount").textContent = `Total: ${totalAmount} BDT`;
        }
    }
}

// Confirm the order and store it in localStorage
function confirmOrder() {
    const paymentType = document.getElementById("payment-type").value;
    const order = JSON.parse(localStorage.getItem("order")) || [];
    let totalAmount = order.reduce((acc, item) => acc + item.price, 0);

    // Apply discounts for online or account payments
    if (paymentType === "online" || paymentType === "account") {
        totalAmount *= 0.9;  // Apply 10% discount
    }

    const confirmedOrder = {
        tableNumber: localStorage.getItem("table-number"), // Assuming table number is stored
        items: order,
        paymentType: paymentType,
        totalAmount: totalAmount.toFixed(2),
        status: "Pending"
    };

    // Save the confirmed order to 'orders' in localStorage
    const orders = JSON.parse(localStorage.getItem("orders")) || [];
    orders.push(confirmedOrder);
    localStorage.setItem("orders", JSON.stringify(orders));

    alert("Order confirmed!");
}

// Display all confirmed orders in the order management page
function displayOrders() {
    const orders = JSON.parse(localStorage.getItem('orders')) || [];
    const orderList = document.getElementById("order-list");

    if (orderList) {
        orderList.innerHTML = "";  // Clear any existing orders in the table

        orders.forEach((order, index) => {
            const row = document.createElement("tr");
            const itemsList = order.items.map(item => item.name).join(", ");
            row.innerHTML = `
                <td>${order.tableNumber || "N/A"}</td>
                <td>${itemsList}</td>
                <td>${order.paymentType}</td>
                <td>${order.totalAmount} BDT</td>
                <td>${order.status}</td>
                <td>
                    <button onclick="markAsDelivered(${index})">Mark as Delivered</button>
                </td>
            `;
            orderList.appendChild(row);
        });
    }
}

// Mark an order as delivered and update in localStorage
function markAsDelivered(index) {
    const orders = JSON.parse(localStorage.getItem('orders')) || [];
    if (orders[index].status === "Pending") {
        orders[index].status = "Delivered";
        localStorage.setItem('orders', JSON.stringify(orders));
        alert(`Order for Table ${orders[index].tableNumber} marked as delivered.`);
        displayOrders();  // Refresh the order list after marking as delivered
    } else {
        alert("This order has already been delivered.");
    }
}

// Event listeners and initialization
document.addEventListener('DOMContentLoaded', function() {
    // If the payment page is loaded, enable order confirmation
    if (document.getElementById('confirm-order')) {
        document.getElementById('confirm-order').addEventListener('click', confirmOrder);
    }
    
    // If the order management page is loaded, display confirmed orders
    if (document.getElementById('order-list')) {
        displayOrders();  // Display orders in the order management page
    }

    // Load order summary on the payment page
    loadOrder();
});
