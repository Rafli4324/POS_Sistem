@extends('layouts.app')

@section('content')
<div class="h-full flex gap-6">
    <!-- Menus Section -->
    <div class="w-2/3 flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-200 p-6 overflow-hidden">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Pilih Menu</h2>
        <div class="flex-1 overflow-y-auto pr-2">
            <div class="grid grid-cols-3 gap-4">
                @foreach($menus as $menu)
                <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-indigo-500 hover:shadow-md transition-all flex flex-col justify-between h-32"
                     onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }}, {{ $menu->stok_saat_ini }})">
                    <div>
                        <h3 class="font-bold text-gray-800 line-clamp-2 text-sm">{{ $menu->nama_menu }}</h3>
                        <span class="text-xs text-gray-500 mt-1 block">{{ $menu->kategori }}</span>
                    </div>
                    <div class="flex justify-between items-end mt-2">
                        <span class="font-semibold text-indigo-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-400">Stok: {{ $menu->stok_saat_ini }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div class="w-1/3 flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Keranjang</h2>
        
        @if(session('error'))
        <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="mb-4 bg-green-50 text-green-600 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex-1 overflow-y-auto mb-4 border-b border-gray-100" id="cart-items">
            <!-- Cart items will be rendered here via JS -->
            <div class="text-center text-gray-400 mt-10 text-sm" id="empty-cart-msg">
                Keranjang masih kosong.
            </div>
        </div>

        <!-- Rekomendasi AI -->
        <div id="recommendations-container" class="hidden mb-4 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
            <h3 class="text-xs font-bold text-indigo-800 uppercase tracking-wider mb-2 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Disarankan
            </h3>
            <div id="recommendation-list" class="space-y-2">
                <!-- Data from JS -->
            </div>
        </div>

        <div class="pt-2">
            <div class="flex justify-between items-center mb-2">
                <span class="font-bold text-gray-700">Total</span>
                <span class="font-bold text-2xl text-gray-900" id="cart-total">Rp 0</span>
            </div>
            
            <div class="mb-4">
                <label for="cash_input" class="block text-sm font-medium text-gray-700 mb-1">Uang Tunai (Cash)</label>
                <div style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0 0.75rem; background-color: #fff; focus-within: outline: 2px solid #6366f1;">
                    <span style="color: #6b7280; font-weight: 500; margin-right: 0.5rem;">Rp</span>
                    <input type="number" id="cash_input" min="0" step="500" oninput="calculateChange()" style="flex: 1; border: none; outline: none; padding: 0.5rem 0; width: 100%; background: transparent; font-size: 1rem;" placeholder="0">
                </div>
                <div class="flex justify-between items-center mt-2 text-sm">
                    <span class="text-gray-500">Kembalian:</span>
                    <span class="font-bold text-gray-900" id="change-amount">Rp 0</span>
                </div>
            </div>
            
            <form action="{{ route('transactions.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="cart" id="cart-input" value="[]">
                <button type="button" id="submit-btn" onclick="submitOrder()" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-700 transition-colors shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Proses Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let cartTotal = 0;

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateChange() {
        const cashInput = document.getElementById('cash_input').value;
        const changeAmountEl = document.getElementById('change-amount');
        const submitBtn = document.getElementById('submit-btn');
        
        let cash = parseInt(cashInput) || 0;
        let change = cash - cartTotal;
        
        if (cart.length > 0 && cash >= cartTotal) {
            changeAmountEl.textContent = formatRupiah(change);
            changeAmountEl.classList.remove('text-red-500');
            submitBtn.disabled = false;
        } else if (cart.length > 0 && cash > 0 && cash < cartTotal) {
            changeAmountEl.textContent = "Uang kurang " + formatRupiah(Math.abs(change));
            changeAmountEl.classList.add('text-red-500');
            submitBtn.disabled = true;
        } else {
            changeAmountEl.textContent = "Rp 0";
            changeAmountEl.classList.remove('text-red-500');
            submitBtn.disabled = cart.length === 0;
        }
    }

    function addToCart(id, name, price, maxStock) {
        let existing = cart.find(item => item.id === id);
        if (existing) {
            if (existing.qty < maxStock) {
                existing.qty++;
            } else {
                alert('Stok tidak mencukupi!');
            }
        } else {
            if (maxStock > 0) {
                cart.push({ id: id, name: name, price: price, qty: 1, max: maxStock });
            } else {
                alert('Stok habis!');
            }
        }
        renderCart();
    }

    function updateQty(id, change) {
        let item = cart.find(i => i.id === id);
        if (item) {
            let newQty = item.qty + change;
            if (newQty > 0 && newQty <= item.max) {
                item.qty = newQty;
            } else if (newQty === 0) {
                cart = cart.filter(i => i.id !== id);
            } else if (newQty > item.max) {
                alert('Stok maksimal tercapai!');
            }
            renderCart();
        }
    }

    function renderCart() {
        const container = document.getElementById('cart-items');
        const totalEl = document.getElementById('cart-total');
        const cartInput = document.getElementById('cart-input');

        if (cart.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-400 mt-10 text-sm" id="empty-cart-msg">Keranjang masih kosong.</div>';
            totalEl.textContent = 'Rp 0';
            cartInput.value = '[]';
            cartTotal = 0;
            calculateChange();
            return;
        }

        let html = '';
        cartTotal = 0;

        cart.forEach(item => {
            cartTotal += item.price * item.qty;
            html += `
                <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                    <div class="flex-1 pr-2">
                        <h4 class="text-sm font-semibold text-gray-800 line-clamp-1">${item.name}</h4>
                        <span class="text-xs text-gray-500">${formatRupiah(item.price)}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200">-</button>
                        <span class="text-sm font-medium w-4 text-center">${item.qty}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200">+</button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        totalEl.textContent = formatRupiah(cartTotal);
        
        // Prepare data for backend
        const exportCart = cart.map(item => ({ id: item.id, harga: item.price, qty: item.qty }));
        cartInput.value = JSON.stringify(exportCart);
        
        calculateChange();
        fetchRecommendations();
    }

    function fetchRecommendations() {
        const recContainer = document.getElementById('recommendations-container');
        const recList = document.getElementById('recommendation-list');
        
        if (cart.length === 0) {
            recContainer.classList.add('hidden');
            return;
        }

        const productIds = cart.map(item => `product_ids[]=${item.id}`).join('&');
        fetch(`/api/recommendations?${productIds}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    recContainer.classList.remove('hidden');
                    let html = '';
                    data.forEach(rule => {
                        let menu = rule.consequent;
                        html += `
                            <div class="flex justify-between items-center bg-white p-2 rounded border border-indigo-50">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-800 line-clamp-1">${menu.nama_menu}</h4>
                                    <span class="text-xs text-indigo-600 font-semibold">${formatRupiah(menu.harga)}</span>
                                </div>
                                <button type="button" onclick="addToCart(${menu.id}, '${menu.nama_menu.replace(/'/g, "\\'")}', ${menu.harga}, ${menu.stok_saat_ini})" class="px-2 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded text-xs font-bold transition-colors">
                                    Tambah
                                </button>
                            </div>
                        `;
                    });
                    recList.innerHTML = html;
                } else {
                    recContainer.classList.add('hidden');
                }
            })
            .catch(err => console.error(err));
    }

    function submitOrder() {
        if (cart.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }
        
        const cash = parseInt(document.getElementById('cash_input').value) || 0;
        if (cash > 0 && cash < cartTotal) {
            alert('Uang tunai kurang dari total belanja!');
            return;
        }
        
        document.getElementById('checkout-form').submit();
    }
</script>
@endsection
