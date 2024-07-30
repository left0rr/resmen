@props(['menuitem'])

<div x-show="showModal" class="fixed inset-0 overflow-y-auto flex items-center justify-center z-50" x-cloak>
    <div @click="showModal = false" class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="showModal" class="bg-white p-8 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full" @click.away="showModal = false">
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

                    <!-- Buttons -->
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
                        <button class="w-full px-4 py-2 bg-green-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Item
                        </button>
                        <button class="w-full px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
