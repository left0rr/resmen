@props(['menuitem'])

<div x-data="{ showModal: false, showDeleteModal: false ,showUpdateModal: false}" @keydown.escape.window="showModal = false">
    <div @click.prevent="showModal = true" class="food-card">
        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $menuitem->image_url }}" alt="{{ $menuitem->name }}">
        <div class="p-5">
            <h5 class="text-2xl font-bold mb-2">{{ $menuitem->name }}</h5>
            <p class="mb-3 font-normal text-gray-700">{{ $menuitem->description }}</p>
            <span class="text-lg font-semibold mt-0">{{ $menuitem->price }}DT</span>
        </div>
    </div>

    <!-- Main Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
        <div class="bg-white p-8 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full max-h-full overflow-y-auto" @click.away="showModal = false">
            <!-- Modal content -->
            <div class="relative z-10" role="dialog" aria-modal="true">
                <div class="flex justify-end">
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 mt-4">
                    <div class="col-span-1">
                        <img src="{{ $menuitem->image_url }}" alt="{{ $menuitem->name }}" class="rounded-lg w-full">
                        <div class="mt-4 space-y-4">
                            <button @click.prevent="addToCart({
                            id: {{ $menuitem->id }},
                            name: '{{ $menuitem->name }}',
                            price: {{ $menuitem->price }},
                            image: '{{ $menuitem->image_url }}'
                        })"
                                    class="w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add to Cart
                            </button>
                            @auth
                                <button @click="showUpdateModal = true" class="w-full px-4 py-2 bg-green-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Update Item
                                </button>
                                <button @click="showDeleteModal = true" class="w-full px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete Item
                                </button>
                            @endauth
                        </div>
                    </div>
                    <div class="col-span-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $menuitem->name }}</h2>
                        <p class="text-gray-700">{{ $menuitem->description }}</p>
                        <p class="text-2xl mt-4 font-bold">{{ $menuitem->price }}DT</p>
                        <!-- Sizes -->
                        <div class="mt-6">
                            <label for="sizes" class="block text-sm font-medium text-gray-700">Choose a size:</label>
                            <select id="sizes" name="sizes" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="regular">Regular</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                        <!-- Supplements -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700">Choose supplements:</label>
                            <div class="mt-2 space-y-4">
                                <div class="flex items-center">
                                    <input id="supplement1" name="supplement1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="supplement1" class="ml-3 block text-sm font-medium text-gray-700">Extra Cheese</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="supplement2" name="supplement2" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="supplement2" class="ml-3 block text-sm font-medium text-gray-700">Bacon</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="supplement3" name="supplement3" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="supplement3" class="ml-3 block text-sm font-medium text-gray-700">Mushrooms</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Item Modal -->
    <div x-show="showUpdateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-60" x-cloak>
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-2xl mb-4">Update Menu Item</h2>
            <form id="updateItemForm" method="POST" action="{{ route('menuitem.update', $menuitem->id) }}">
                @csrf
                @method('PATCH') <!-- Use PATCH if it's a partial update -->
                <div class="mb-4">
                    <label for="item_name" class="block text-gray-700">Item Name</label>
                    <input type="text" id="item_name" name="item_name" class="w-full px-3 py-2 border rounded" value="{{ $menuitem->name }}" required>
                </div>
                <div class="mb-4">
                    <label for="item_description" class="block text-gray-700">Item Description</label>
                    <textarea id="item_description" name="item_description" class="w-full px-3 py-2 border rounded" required>{{ $menuitem->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="item_price" class="block text-gray-700">Item Price</label>
                    <input type="number" id="item_price" name="item_price" class="w-full px-3 py-2 border rounded" value="{{ $menuitem->price }}" required>
                </div>
                <div class="mb-4">
                    <label for="image_url" class="block text-gray-700">Image URL</label>
                    <input type="text" id="image_url" name="image_url" class="w-full px-3 py-2 border rounded" value="{{ $menuitem->image_url }}">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" @click="showUpdateModal = false">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update Item</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" class="fixed inset-0 flex items-center justify-center z-60 bg-gray-600 bg-opacity-50" x-cloak>
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h2 class="text-2xl mb-4">Confirm Deletion</h2>
            <p>Are you sure you want to delete this item?</p>
            <div class="flex justify-end mt-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mr-2" @click="showDeleteModal = false">Cancel</button>
                <form id="delete-form" action="{{ route('menuitem.destroy', $menuitem->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

