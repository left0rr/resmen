<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/cart.js'])
</head>
<body class="bg-peor2 text-yellow-500">
<!-- Sidebar -->
<div class="sidebar">
    <h2></h2>
    <ul class="flex-1">
        <li class="mt-scroll-60">
            <a href="/">
                <img src="{{ Vite::asset('resources/images/taco.gif') }}" alt="taco GIF" class="resized-gif">
            </a>
        </li>
        @auth
            <li>
                <button type="button" class="flex-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="showModal = true">Add Category</button>
            </li>
        @endauth
        @foreach ($categories as $cat)
            <x-nav-category :category="$cat" :active="false" />
        @endforeach
    </ul>
</div>

<!-- Content -->
<div class="container">

    <header>
        <div>

        </div>

        <div class="icon-cart">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
            </svg>
            <span>0</span>
        </div>
    </header>
    <div id="contentTab" class="content grid lg:grid-cols-3 ml-200 gap-3 mt-1">
        @foreach ($menuitems as $menuitem)
            <x-food-card :menuitem="$menuitem" :active="false" @click="$dispatch('add-to-cart', { id: {{ $menuitem->id }}, name: '{{ $menuitem->name }}', price: {{ $menuitem->price }}, image: '{{ $menuitem->image_url }}', quantity: 1 })" />
        @endforeach
    </div>
</div>
<div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="listCart"> show item here</div>
    <div class="btn">
        <button class="close">CLOSE</button>
        <button class="checkout">Checkout</button>
    </div>
</div>
<script>
    function cartData() {
        return {
            cartOpen: false,
            cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
            totalPrice: JSON.parse(localStorage.getItem('totalPrice')) || 0,

            addToCart(item) {
                let existingItem = this.cartItems.find(i => i.id === item.id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    item.quantity = 1; // Set initial quantity to 1 for new items
                    this.cartItems.push(item);
                }
                this.calculateTotal();
                this.saveToLocalStorage();
            },


            removeItem(id) {
                this.cartItems = this.cartItems.filter(item => item.id !== id);
                this.calculateTotal();
            },

            calculateTotal() {
                this.totalPrice = this.cartItems.reduce((total, item) => {
                    return total + (item.price * item.quantity);
                }, 0);
                this.saveToLocalStorage();
            },

            saveToLocalStorage() {
                localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                localStorage.setItem('totalPrice', JSON.stringify(this.totalPrice));
            },

            clearCart() {
                this.cartItems = [];
                this.totalPrice = 0;
                this.saveToLocalStorage();
                this.cartOpen = false;
            },

            init() {
                window.addEventListener('add-to-cart', event => {
                    this.addToCart(event.detail);
                });
            }
        }
    }




    function openUpdateModal() {
        document.getElementById('update-modal').classList.remove('hidden');
    }

    function closeUpdateModal() {
        document.getElementById('update-modal').classList.add('hidden');
    }

    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }

    function openAddItemsModal() {
        document.getElementById('add-items-modal').classList.remove('hidden');
    }

    function closeAddItemsModal() {
        document.getElementById('add-items-modal').classList.add('hidden');
    }

</script>





</body>
</html>
