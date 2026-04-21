@props(['product'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group">
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        
        @if ($product['sale_price'] < $product['price'])
            <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-{{ round((($product['price'] - $product['sale_price']) / $product['price']) * 100) }}%</span>
        @endif
        
        <span class="absolute top-4 right-4 bg-pasardigital-green text-white text-xs px-3 py-1 rounded-full">{{ $product['category'] }}</span>
    </div>
    
    <div class="p-6">
        <h3 class="font-semibold text-lg text-gray-800 mb-2 truncate group-hover:text-pasardigital-green">{{ $product['name'] }}</h3>
        
        <div class="flex items-center gap-1 mb-3">
            @for ($i = 0; $i < 5; $i++)
                <i class="fas fa-star text-sm {{ $i < $product['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
            @endfor
            <span class="text-xs text-gray-500 ml-2">({{ $product['review_count'] }})</span>
        </div>

        <div class="flex items-baseline gap-2 mb-4">
            @if ($product['sale_price'] < $product['price'])
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($product['sale_price'], 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500 line-through">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
            @else
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
            @endif
        </div>

        <div class="flex gap-2">
            <button class="btn-green flex-1">Beli</button>
            <button class="bg-gray-100 text-pasardigital-green p-3 rounded-lg hover:bg-gray-200"><i class="fas fa-shopping-cart"></i></button>
            <button class="bg-gray-100 text-gray-500 p-3 rounded-lg hover:bg-gray-200"><i class="fas fa-heart"></i></button>
        </div>
    </div>
</div>