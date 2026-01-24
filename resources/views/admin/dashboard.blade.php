<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cordova - Kitchen Panel</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/img/logo.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Fredoka', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        /* Hide arrows in number input */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; margin: 0; 
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-10" 
      x-data="adminPanel({{ Js::from($orders) }}, {{ Js::from($products) }})">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40 px-6 py-4 shadow-sm">
        <div class="container mx-auto max-w-6xl flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold font-display text-xl shadow-blue-200 shadow-lg">A</div>
                <div>
                    <span class="font-bold text-slate-800 tracking-tight block leading-none">Kitchen Panel</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Cordova Dashboard</span>
                </div>
            </div>
            
            <div class="hidden md:flex bg-slate-100 p-1 rounded-xl">
                <button @click="activeTab = 'orders'" 
                    class="px-6 py-2 rounded-lg text-sm font-bold transition-all duration-200"
                    :class="activeTab === 'orders' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">
                    Pesanan
                </button>
                <button @click="activeTab = 'stocks'" 
                    class="px-6 py-2 rounded-lg text-sm font-bold transition-all duration-200"
                    :class="activeTab === 'stocks' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">
                    Stok Menu
                </button>
                <button @click="activeTab = 'revenue'" 
                    class="px-6 py-2 rounded-lg text-sm font-bold transition-all duration-200"
                    :class="activeTab === 'revenue' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'">
                    Laporan
                </button>
            </div>

            <div class="flex items-center gap-4">
                <a href="/admin/logout" class="bg-slate-100 hover:bg-red-50 hover:text-red-500 text-slate-500 p-2 rounded-lg transition" title="Logout">
                    <i class="ph-bold ph-sign-out text-xl"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="md:hidden px-6 py-4 bg-white border-b border-slate-200 mb-4 overflow-x-auto flex gap-2">
        <button @click="activeTab = 'orders'" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap border" :class="activeTab === 'orders' ? 'bg-blue-50 border-blue-200 text-blue-600' : 'border-slate-100 text-slate-500'">Pesanan</button>
        <button @click="activeTab = 'stocks'" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap border" :class="activeTab === 'stocks' ? 'bg-blue-50 border-blue-200 text-blue-600' : 'border-slate-100 text-slate-500'">Stok Menu</button>
        <button @click="activeTab = 'revenue'" class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap border" :class="activeTab === 'revenue' ? 'bg-blue-50 border-blue-200 text-blue-600' : 'border-slate-100 text-slate-500'">Laporan</button>
    </div>

    <div class="container mx-auto max-w-6xl px-6 py-4">

        <div x-show="activeTab === 'orders'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Antrian Masuk</h1>
                    <p class="text-slate-400 text-sm">Real-time order monitoring.</p>
                </div>
                <button @click="window.location.reload()" class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-slate-600 font-bold text-sm hover:border-blue-500 hover:text-blue-600 transition shadow-sm flex items-center gap-2">
                    <i class="ph-bold ph-arrows-clockwise text-lg"></i> Refresh
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <template x-for="order in orders" :key="order.id">
                    <div @click="openModal(order)" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 cursor-pointer group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 left-0 right-0 h-1.5" :class="{'bg-blue-500': order.status === 'Menunggu', 'bg-yellow-400': order.status === 'Dimasak', 'bg-green-500': order.status === 'Selesai', 'bg-red-500': order.status === 'Batal'}"></div>
                        <div class="flex justify-between items-start mb-4 mt-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-bold text-slate-500 text-lg" x-text="order.customer_name.charAt(0)"></div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-lg leading-tight line-clamp-1" x-text="order.customer_name"></h3>
                                    <p class="text-xs text-slate-400 font-bold mt-1 uppercase">Order #<span x-text="order.id"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-slate-500 mb-4 bg-slate-50 p-3 rounded-xl">
                            <div class="flex items-center gap-1.5"><i class="ph-bold ph-clock text-slate-400"></i> <span x-text="formatTime(order.created_at)"></span></div>
                            <div class="w-px h-4 bg-slate-300"></div>
                            <div class="flex items-center gap-1.5"><i class="ph-bold ph-package text-slate-400"></i> <span x-text="order.items.length + ' Item'"></span></div>
                        </div>
                        <div class="mt-auto flex justify-between items-center">
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border" :class="{'bg-blue-50 text-blue-600 border-blue-100': order.status === 'Menunggu', 'bg-yellow-50 text-yellow-600 border-yellow-100': order.status === 'Dimasak', 'bg-green-50 text-green-600 border-green-100': order.status === 'Selesai', 'bg-red-50 text-red-600 border-red-100': order.status === 'Batal'}" x-text="order.status"></span>
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-500 group-hover:text-white transition"><i class="ph-bold ph-caret-right"></i></div>
                        </div>
                    </div>
                </template>
                <div x-show="orders.length === 0" class="col-span-full text-center py-20 text-slate-400 bg-white rounded-2xl border border-dashed border-slate-200"><p>Belum ada pesanan masuk.</p></div>
            </div>
        </div>

        <div x-show="activeTab === 'stocks'" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Manajemen Stok</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <template x-for="product in products" :key="product.id">
                    <div class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
                        
                        <div class="absolute top-0 left-0 right-0 h-1.5" 
                             :class="product.stock < 5 ? 'bg-red-500 animate-pulse' : 'bg-green-500'"></div>

                        <div class="flex items-center gap-4 mb-4 mt-2">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-slate-50 shadow-sm shrink-0">
                                <img :src="product.image" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-800 text-lg leading-tight line-clamp-2" x-text="product.name"></h3>
                                <p class="text-xs text-slate-400 mt-1" x-show="product.stock < 5">⚠️ Stok Menipis!</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-1.5 rounded-2xl flex items-center justify-between mb-4 border border-slate-100">
                            <button @click="if(product.stock > 0) product.stock--" 
                                class="w-10 h-10 rounded-xl bg-white text-slate-400 hover:text-red-500 hover:shadow-md transition flex items-center justify-center border border-slate-200">
                                <i class="ph-bold ph-minus"></i>
                            </button>
                            
                            <input type="number" x-model="product.stock" 
                                class="w-16 bg-transparent text-center font-display font-bold text-2xl text-slate-800 focus:outline-none"
                                :class="product.stock < 5 ? 'text-red-500' : ''">
                            
                            <button @click="product.stock++" 
                                class="w-10 h-10 rounded-xl bg-slate-900 text-white hover:bg-black hover:shadow-md transition flex items-center justify-center">
                                <i class="ph-bold ph-plus"></i>
                            </button>
                        </div>

                        <button @click="updateStock(product)" 
                            class="w-full py-3 rounded-xl font-bold text-sm transition flex items-center justify-center gap-2 group-hover:-translate-y-0.5"
                            :class="product.stock < 5 ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-blue-50 text-blue-600 hover:bg-blue-100'">
                            <i class="ph-bold ph-floppy-disk"></i> Simpan Stok
                        </button>

                    </div>
                </template>
            </div>
        </div>

        <div x-show="activeTab === 'revenue'" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Ringkasan Laporan</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-3xl mb-4">
                        <i class="ph-fill ph-money"></i>
                    </div>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mb-1">Total Pendapatan</p>
                    <h3 class="text-4xl font-display font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-xs text-slate-400 mt-4 bg-slate-50 px-3 py-1 rounded-full">Akumulasi pesanan "Selesai"</p>
                </div>

                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-3xl mb-4">
                        <i class="ph-fill ph-receipt"></i>
                    </div>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mb-1">Total Pesanan Hari Ini</p>
                    <h3 class="text-4xl font-display font-bold text-slate-800">{{ $totalOrdersToday }}</h3>
                    <p class="text-xs text-slate-400 mt-4 bg-slate-50 px-3 py-1 rounded-full">Pesanan Masuk</p>
                </div>
            </div>
        </div>

    </div>

    <div x-show="selectedOrder" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="selectedOrder = null"></div>
        <div x-show="selectedOrder" class="bg-white w-full sm:max-w-md rounded-t-[2rem] sm:rounded-[2rem] p-6 shadow-2xl relative z-10 flex flex-col max-h-[90vh]">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden shrink-0"></div>
            <div class="flex justify-between items-start mb-6 border-b border-dashed border-slate-200 pb-4">
                <div>
                    <h2 class="font-display font-bold text-2xl text-slate-900" x-text="selectedOrder?.customer_name"></h2>
                    <p class="text-sm text-slate-400">Order ID #<span x-text="selectedOrder?.id"></span></p>
                </div>
                <button @click="selectedOrder = null" class="bg-slate-50 p-2 rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition"><i class="ph-bold ph-x text-xl"></i></button>
            </div>
            <div class="flex-grow overflow-y-auto pr-2 mb-6 space-y-3 custom-scroll">
                <template x-for="item in selectedOrder?.items">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600 font-medium"><span class="font-bold text-slate-900 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded text-xs mr-2" x-text="item.quantity + 'x'"></span> <span x-text="item.product_name"></span></span>
                    </div>
                </template>
                <div x-show="selectedOrder?.customer_notes" class="bg-yellow-50 p-3 rounded-xl border border-yellow-100 mt-4">
                    <p class="text-[10px] text-yellow-700 font-bold uppercase mb-1">Catatan:</p>
                    <p class="text-sm text-slate-700 italic">"<span x-text="selectedOrder?.customer_notes"></span>"</p>
                </div>
            </div>
            <div class="mt-auto pt-2">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-slate-500 text-sm">Total Harga</span>
                    <span class="font-display font-bold text-xl text-blue-600" x-text="formatRupiah(selectedOrder?.total_price)"></span>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    <button @click="updateStatus('Menunggu')" class="p-2 rounded-xl flex flex-col items-center justify-center gap-1 border-2 transition" :class="selectedOrder?.status === 'Menunggu' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-slate-100 text-slate-400 hover:border-blue-200'"><i class="ph-fill ph-hourglass text-xl"></i><span class="text-[10px] font-bold">Antri</span></button>
                    <button @click="updateStatus('Dimasak')" class="p-2 rounded-xl flex flex-col items-center justify-center gap-1 border-2 transition" :class="selectedOrder?.status === 'Dimasak' ? 'border-yellow-400 bg-yellow-50 text-yellow-600' : 'border-slate-100 text-slate-400 hover:border-yellow-200'"><i class="ph-fill ph-fire text-xl"></i><span class="text-[10px] font-bold">Masak</span></button>
                    <button @click="updateStatus('Selesai')" class="p-2 rounded-xl flex flex-col items-center justify-center gap-1 border-2 transition" :class="selectedOrder?.status === 'Selesai' ? 'border-green-500 bg-green-50 text-green-600' : 'border-slate-100 text-slate-400 hover:border-green-200'"><i class="ph-fill ph-check-circle text-xl"></i><span class="text-[10px] font-bold">Selesai</span></button>
                    <button @click="updateStatus('Batal')" class="p-2 rounded-xl flex flex-col items-center justify-center gap-1 border-2 transition" :class="selectedOrder?.status === 'Batal' ? 'border-red-500 bg-red-50 text-red-600' : 'border-slate-100 text-slate-400 hover:border-red-200'"><i class="ph-fill ph-x-circle text-xl"></i><span class="text-[10px] font-bold">Batal</span></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function adminPanel(ordersData, productsData) {
            return {
                activeTab: 'orders', // Default Tab
                orders: ordersData,
                products: productsData, 
                selectedOrder: null,

                openModal(order) { this.selectedOrder = order; },
                formatRupiah(val) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val || 0); },
                formatTime(dateString) { const date = new Date(dateString); return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }); },
                
                async updateStatus(newStatus) {
                    if(!this.selectedOrder) return;
                    const oldStatus = this.selectedOrder.status;
                    this.selectedOrder.status = newStatus;
                    try {
                        const response = await fetch(`/admin/update/${this.selectedOrder.id}`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                            body: JSON.stringify({ status: newStatus })
                        });
                        const result = await response.json();
                        if(result.success) {
                            const index = this.orders.findIndex(o => o.id === this.selectedOrder.id);
                            if(index !== -1) { this.orders[index].status = newStatus; }
                            if(newStatus === 'Selesai' || oldStatus === 'Selesai') setTimeout(() => window.location.reload(), 500);
                        } else { this.selectedOrder.status = oldStatus; alert('Gagal update status!'); }
                    } catch (e) { this.selectedOrder.status = oldStatus; alert('Error koneksi.'); }
                },

                // LOGIC UPDATE STOK
                async updateStock(product) {
                    try {
                        const response = await fetch(`/admin/stock/${product.id}`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                            body: JSON.stringify({ stock: product.stock })
                        });
                        const result = await response.json();
                        if(result.success) {
                            alert(`Stok ${product.name} berhasil diupdate jadi ${product.stock}!`);
                        } else {
                            alert('Gagal update stok.');
                        }
                    } catch (e) {
                        alert('Error koneksi.');
                    }
                }
            }
        }
    </script>
</body>
</html>