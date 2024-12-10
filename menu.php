<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu - Green Cafe</title>
    <link rel="stylesheet" href="food_menu.css">
</head>
<body>
    <div class="menu-container">
        <h1>Green Cafe Menu</h1>
        <div class="menu-items" id="menuItems"></div>
        <h3 id="total-price">Total Price: 0 BDT</h3>
        <button id="place-order" style="display: none;">Place Order</button>
    </div>

    <script>
        const menuItems = [
            { name: "Burger", price: 100, img: "images/burger.jpg" },
            { name: "Pizza", price: 200, img: "images/pizza.jpg" },
            // (others)
        ];

        let totalPrice = 0;
        const cart = [];

        // Menu rendering
        const menuContainer = document.getElementById('menuItems');
        menuItems.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('menu-item');

            itemDiv.innerHTML = `
                <img src="${item.img}" alt="${item.name}">
                <div class="item-info">
                    <h3>${item.name}</h3>
                    <p>Price: ${item.price} BDT</p>
                    <input type="number" min="1" value="1" class="quantity-input" data-price="${item.price}">
                    <button class="add-to-cart" data-name="${item.name}" data-price="${item.price}">Add to Cart</button>
                </div>
            `;
            menuContainer.appendChild(itemDiv);
        });

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const price = parseInt(this.getAttribute('data-price'));
                const quantityInput = this.previousElementSibling;
                const quantity = parseInt(quantityInput.value);

                const itemTotal = price * quantity;
                totalPrice += itemTotal;
                document.getElementById('total-price').innerText = `Total Price: ${totalPrice} BDT`;

                cart.push({ name, price, quantity });
                document.getElementById('place-order').style.display = 'block';
            });
        });

        // Order placement logic
        document.getElementById('place-order').addEventListener('click', () => {
            if (cart.length > 0) {
                localStorage.setItem('orders', JSON.stringify(cart));
                window.location.href = 'payment.php?total=' + totalPrice;
            } else {
                alert("Please add items to your cart.");
            }
        });
    </script>
</body>
</html>
