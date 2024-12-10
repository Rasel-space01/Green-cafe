const menuItems = [
    { name: "Burger", price: 100, img: "https://via.placeholder.com/150" },
    { name: "Pizza", price: 200, img: "https://via.placeholder.com/150" },
    { name: "Pasta", price: 150, img: "https://via.placeholder.com/150" },
    { name: "Sandwich", price: 80, img: "https://via.placeholder.com/150" }
];

const menuContainer = document.getElementById('menu-items');
const orderList = document.getElementById('order-list');
const managerOrderList = document.getElementById('manager-order-list');
const tableSection = document.getElementById('table-section');
const orderSection = document.getElementById('order-section');
const managerSection = document.getElementById('manager-section');
let tableNumber = null;
let orders = [];

// Start order button event listener
document.getElementById('start-order').addEventListener('click', () => {
    tableNumber = document.getElementById('table-number').value;
    if (tableNumber) {
        tableSection.style.display = 'none';
        orderSection.style.display = 'block';
    } else {
        alert("Please enter your table number.");
    }
});

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
function addToOrder(name, price) {
    const listItem = document.createElement('li');
    listItem.textContent = `${name} - ${price} BDT`;
    orderList.appendChild(listItem);
    orders.push({ table: tableNumber, name, price });
}

// Place order button event listener
document.getElementById('place-order').addEventListener('click', () => {
    if (tableNumber && orderList.children.length > 0) {
        alert(`Your order has been placed from table number ${tableNumber}!`);
        updateManagerOrderList();
        orderList.innerHTML = ''; // Clear order list after placing order
        tableNumber = null;
        tableSection.style.display = 'block';
        orderSection.style.display = 'none';
        document.getElementById('table-number').value = '';
    } else {
        alert("Please select items from the menu.");
    }
});

// Update manager order list
function updateManagerOrderList() {
    managerOrderList.innerHTML = '';
    orders.forEach(order => {
        const listItem = document.createElement('li');
        listItem.textContent = `Table ${order.table}: ${order.name} - ${order.price} BDT`;
        managerOrderList.appendChild(listItem);
    });
}

// Toggle manager view
document.getElementById('toggle-manager-view').addEventListener('click', () => {
    if (managerSection.style.display === 'none') {
        managerSection.style.display = 'block';
    } else {
        managerSection.style.display = 'none';
    }
});
