<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>res-menu</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <style>
        /* You can add custom styles here */
    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<body class="bg-peor2 text-yellow-500" x-data="cartData()" x-init="init()">



<!-- Cart Sidebar -->
<div x-data="{ cartOpen: false }" class="relative">
    <div :class="{'activeTabCart': cartOpen}" class="cart fixed inset-y-0 right-0 w-64 bg-white border-l border-gray-200 p-4 z-40 flex flex-col justify-between h-full">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Your Cart</h2>
                <button @click="cartOpen = false; document.body.classList.remove('activeTabCart')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <template x-for="item in cartItems" :key="item.id">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <img :src="item.image" alt="" class="w-12 h-12 rounded-md mr-3">
                            <div>
                                <h4 class="text-md font-semibold" x-text="item.name"></h4>
                                <p class="text-sm text-gray-600" x-text="item.quantity + ' x ' + item.price + 'DT'"></p>
                            </div>
                        </div>
                        <button @click="removeItem(item.id)" class="text-red-500 hover:text-red-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
        <div>
            <div class="mb-4">
                <label for="discount-code" class="block text-sm font-medium text-gray-700">Discount Code</label>
                <div class="flex mt-1">
                    <input type="text" id="discount-code" x-model="discountCode" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" placeholder="Enter code">
                    <button @click="applyDiscount" class="ml-2 px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <span class="text-lg font-bold">Total</span>
                <span class="text-lg font-bold" x-text="totalPrice + 'DT'"></span>
            </div>

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="cartItems" :value="JSON.stringify(cartItems)">
                <input type="hidden" name="totalPrice" :value="totalPrice">
                <input type="hidden" name="discountCode" :value="discountCode">
                <input type="hidden" name="table" id="tableInput"> <!-- Hidden input for table number -->
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Checkout
                </button>
            </form>
        </div>
    </div>
    <button @click="cartOpen = true; document.body.classList.add('activeTabCart')" class="fixed top-6 right-4 bg-indigo-600 text-white rounded-full p-3 shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
        </svg>
        <span x-text="totalQuantity" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-semibold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white">0</span>
    </button>
</div>




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
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-gray-200 pb-2">
        Our Best Selling Dishes
    </h2>
    <div id='z' class="grid lg:grid-cols-3 gap-3">
        @foreach ($topmenuitems as $menuitem)
            <x-food-card
                :menuitem="$menuitem"
                :active="false"
                @click="$dispatch('add-to-cart', { id: {{ $menuitem->id }}, name: '{{ $menuitem->name }}', price: {{ $menuitem->price }}, image: '{{ $menuitem->image_url }}', quantity: 1 })"
            />
        @endforeach
    </div>
</div>

<!-- Modal Background -->
<div x-show="showModal" id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-2xl mb-4">Add New Category</h2>
        <form id="addCategoryForm" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-gray-700">Image URL</label>
                <input type="text" id="image_url" name="image_url" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" @click="showModal = false">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function cartData() {
        return {
            cartOpen: false,
            showModal: false,
            cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
            totalPrice: JSON.parse(localStorage.getItem('totalPrice')) || 0,
            discountCode: '',
            tableNumber: localStorage.getItem('tableNumber') || '',

            get totalQuantity() {
                return this.cartItems.reduce((total, item) => total + item.quantity, 0);
            },

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
                this.saveToLocalStorage();
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

            applyDiscount() {
                fetch('/apply-discount', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ discountCode: this.discountCode })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Log the response to check if `discountAmount` is present
                        if (data.success) {
                            this.totalPrice = this.totalPrice -data.discountAmount;
                            this.saveToLocalStorage();
                            alert('Discount applied!');
                        } else {
                            alert('Invalid discount code!');
                        }
                    })
                    .catch(error => {
                        console.error('Error applying discount:', error);
                        alert('An error occurred while applying the discount.');
                    });
            },

            init() {
                window.addEventListener('add-to-cart', event => {
                    this.addToCart(event.detail);
                });
                document.getElementById('tableInput').value = this.tableNumber;
            }
        }
    }
</script>


</body>
</html>
