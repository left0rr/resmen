<a {{ $attributes->merge(['class' => 'relative inline-flex items-center px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-purple-400 via-pink-500 to-aquamarine-500 rounded-full leading-5 hover:bg-gradient-to-r hover:from-purple-500 hover:via-pink-600 hover:to-aquamarine-600 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gradient-to-r active:from-purple-600 active:via-pink-700 active:to-aquamarine-700 transition ease-in-out duration-300 transform hover:scale-105']) }}>
    {{ $slot }}
</a>
