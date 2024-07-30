<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Here's a list of recent passed orders.") }}

                    <!-- Orders Table -->
                    <div class="overflow-x-auto mt-4">
                        @if($orders->isEmpty())
                            <p class="text-gray-500">No orders to display.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Table Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order Details
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Price
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    @php
                                        $details = json_decode($order->details, true); // Decode JSON to associative array
                                        $totalPrice = array_reduce($details, function ($carry, $item) {
                                            return $carry + ($item['price'] * $item['quantity']);
                                        }, 0);
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $order->table }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @foreach($details as $item)
                                                <p>{{ $item['name'] }} ({{ $item['quantity'] }}) - {{ $item['price'] }} DT</p>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalPrice }} DT
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
