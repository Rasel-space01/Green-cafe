// Mock users data
const users = [
    { username: '212002099', password: '1234', role: 'student', balance: 500 },
    { username: '212002095', password: '1122', role: 'student', balance: 700 },
    { username: 'manager', password: '1212', role: 'manager' }
];

// Menu Items
const menuItems = [
    { name: "Burger", price: 100, img: "images/burger.jpg" },
    { name: "Pizza", price: 200, img: "images/pizza.jpg" },
    { name: "Pasta", price: 50, img: "images/pasta.jpg" },
    { name: "Sandwich", price: 80, img: "images/sandwich.png" },
    { name: "Sushi", price: 100, img: "images/susi.png" },
    { name: "Singara", price: 10, img: "images/singara.jpg" },
    { name: "Puri", price: 10, img: "images/puri.jpg" },
    { name: "Steak", price: 250, img: "images/stake.png" },
    { name: "Noodles", price: 30, img: "images/noodles.png" },
    { name: "Curry", price: 100, img: "images/curry.png" },
    { name: "Fried Rice", price: 90, img: "images/fride.png" },
    { name: "Ice Cream", price: 60, img: "images/ice.png" },
    { name: "Chocolate Cake", price: 40, img: "images/cake.png" },
    { name: "Coffee", price: 20, img: "images/cofe.png" }
];

// Student Dashboard handling
if (document.getElementById('start-order')) {
    const balanceDisplay = document.getElementById('balance-display');
    const menuContainer = document.getElementById('menu-items');
    const orderList = document.getElementById('order-list');
    const tableSection = document.getElementById('table-section');
    const orderSection = document.getElementById('order-section');
    let orderSummary = [];

    // Load menu items
    menuItems.forEach(item => {
        const menuItem = document.createElement('div');
        menuItem.classList.add('menu-item');
        menuItem.innerHTML = `
            <img src="${item.img}" alt="${item.name}">
            <h3>${item.name}</h3>
            <p>Price: ${item.price} BDT</p>
            <button onclick="addToOrder('${item.name}', ${item.price})">Add to Order</button>
        `;
        menuContainer.appendChild(menuItem);
    });

    // Add to order function
    window.addToOrder = function (name, price) {
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
    window.increaseQuantity = function (name) {
        const order = orderSummary.find(order => order.name === name);
        if (order) {
            order.quantity += 1;
            renderOrderList();
        }
    };

    // Decrease quantity
    window.decreaseQuantity = function (name) {
        const order = orderSummary.find(order => order.name === name);
        if (order && order.quantity > 1) {
            order.quantity -= 1;
            renderOrderList();
        } else if (order.quantity === 1) {
            orderSummary = orderSummary.filter(order => order.name !== name);
            renderOrderList();
        }
    };

    // Start order button event listener
    document.getElementById('start-order').addEventListener('click', () => {
        const tableNumber = document.getElementById('table-number').value;
        if (tableNumber) {
            tableSection.style.display = 'none';
            orderSection.style.display = 'block';
        } else {
            alert("Please enter your table number.");
        }
    });

    // Proceed to Payment
    document.getElementById("proceed-payment").onclick = function () {
        if (orderSummary.length > 0) {
            localStorage.setItem("order", JSON.stringify(orderSummary)); // Store order summary
            window.location.href = "payment.html"; // Redirect to payment page
        } else {
            alert("Please add items to your order before proceeding to payment.");
        }
    };
}

// Manager Dashboard handling
if (document.getElementById('manager-order-list')) {
    const managerOrderList = document.getElementById('manager-order-list');

    // Function to update manager order list
    function updateManagerOrderList() {
        const orders = JSON.parse(localStorage.getItem('orders')) || [];
        managerOrderList.innerHTML = '';
        orders.forEach((order, index) => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                Table ${order.table}: ${order.items.map(item => `${item.name} x${item.quantity}`).join(', ')}
                <button onclick="markAsDelivered(${index})">Mark as Delivered</button>
                <span>${order.status}</span>
            `;
            managerOrderList.appendChild(listItem);
        });
    }

    // Function to mark an order as delivered
    window.markAsDelivered = function (index) {
        const orders = JSON.parse(localStorage.getItem('orders')) || [];
        if (orders[index]) {
            orders[index].status = 'Delivered';
            localStorage.setItem('orders', JSON.stringify(orders));
            updateManagerOrderList();

            // Auto-delete logic for the last 5 delivered orders
            const deliveredOrders = orders.filter(order => order.status === 'Delivered');
            if (deliveredOrders.length >= 5) {
                orders.splice(0, 5); // Assuming orders are added sequentially
                localStorage.setItem('orders', JSON.stringify(orders));
                updateManagerOrderList();
            }
        }
    }

    // Load orders on page load
    updateManagerOrderList();
}
