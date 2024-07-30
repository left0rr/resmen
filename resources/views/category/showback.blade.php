<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>res-menu</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body x-data="cartData()" x-init="init()" class="bg-peor2 text-yellow-500">

<!-- Cart Sidebar -->
<div class="relative">
    <div x-show="cartOpen" class="fixed inset-y-0 right-0 w-80 bg-white border-l border-gray-200 p-4 z-40 flex flex-col justify-between h-full">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Your Cart</h2>
                <button @click="cartOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
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
            <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                <span class="text-lg font-bold">Total</span>
                <span class="text-lg font-bold" x-text="totalPrice + 'DT'"></span>
            </div>
            <button class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                PASS ORDER
            </button>
        </div>
    </div>
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
                <button type="button" class="flex-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="openAddItemsModal()">Add Items</button>
            </li>
            <li>
                <button type="button" class="flex-1 rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" onclick="openUpdateModal()">Update Category</button>
            </li>
            <li>
                <button type="button" class="flex-1 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" onclick="openDeleteModal()">Delete Category</button>
            </li>
        @endauth
        @foreach($categories as $cat)
            <x-nav-category :category="$cat" />
        @endforeach
    </ul>
</div>

<!-- Content -->
<div class="container">
    @foreach ($menuitems as $menuitem)
        <x-food-card :menuitem="$menuitem"  />
    @endforeach
    <button @click="cartOpen = true" class="fixed top-6 right-6 bg-indigo-600 text-white rounded-full p-3 shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M3 11h18M3 15h18M3 19h18"></path>
        </svg>
    </button>
</div>

<!-- Update Category Modal -->
<div id="update-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-2xl mb-4">Update Category</h2>
        <form id="updateCategoryForm" method="POST" action="{{ route('category.update', $category->id) }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Category Name</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded" value="{{ $category->name }}" required>
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-gray-700">Image URL</label>
                <input type="text" id="image_url" name="image_url" class="w-full px-3 py-2 border rounded" value="{{ $category->logo }}" required>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" onclick="closeUpdateModal()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-2xl mb-4">Confirm Deletion</h2>
        <p>Are you sure you want to delete this category?</p>
        <div class="flex justify-end mt-4">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" onclick="closeDeleteModal()">Cancel</button>
            <form id="delete-form" action="{{ route('category.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2">Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- Add Items Modal -->
<div id="add-items-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-2xl mb-4">Add Menu Item</h2>
        <form id="addItemForm" method="POST" action="{{ route('menuitems.store', $category->id) }}">
            @csrf
            <div class="mb-4">
                <label for="item_name" class="block text-gray-700">Item Name</label>
                <input type="text" id="item_name" name="item_name" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="item_description" class="block text-gray-700">Item Description</label>
                <textarea id="item_description" name="item_description" class="w-full px-3 py-2 border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="item_price" class="block text-gray-700">Item Price</label>
                <input type="number" id="item_price" name="item_price" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-gray-700">Image URL</label>
                <input type="text" id="image_url" name="image_url" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" onclick="closeAddItemsModal()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add Item</button>
            </div>
        </form>
    </div>
</div>

<script>
    function cartData() {
        return {
            cartOpen: false,
            cartItems: [],
            totalPrice: 0,
            init() {
                this.loadFromLocalStorage();
            },
            addToCart(item) {
                let existingItem = this.cartItems.find(i => i.id === item.id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    item.quantity = 1;
                    this.cartItems.push(item);
                }
                this.calculateTotalPrice();
                this.saveToLocalStorage();
            },
            removeItem(itemId) {
                this.cartItems = this.cartItems.filter(i => i.id !== itemId);
                this.calculateTotalPrice();
                this.saveToLocalStorage();
            },
            calculateTotalPrice() {
                this.totalPrice = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },
            saveToLocalStorage() {
                localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                localStorage.setItem('totalPrice', this.totalPrice);
            },
            loadFromLocalStorage() {
                let cartItems = JSON.parse(localStorage.getItem('cartItems'));
                let totalPrice = localStorage.getItem('totalPrice');
                this.cartItems = cartItems ? cartItems : [];
                this.totalPrice = totalPrice ? parseFloat(totalPrice) : 0;
            },
            handleAddToCart(event) {
                this.addToCart(event.detail);
            }
        }
    }

    window.addEventListener('add-to-cart', function(event) {
        document.querySelector('[x-data="cartData()"]').__x.$data.handleAddToCart(event);
    });

    function openAddItemsModal() {
        document.getElementById('add-items-modal').classList.remove('hidden');
    }

    function closeAddItemsModal() {
        document.getElementById('add-items-modal').classList.add('hidden');
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
</script>

</body>
</html>
