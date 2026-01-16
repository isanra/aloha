<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aloha - Kitchen Panel</title>

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
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-20" x-data="adminPanel({{ Js::from($orders) }})">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40 px-6 py-4 shadow-sm">
        <div class="flex justify-between items-center w-full">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold font-display text-xl shadow-blue-200 shadow-lg">A</div>
                <div>
                    <span class="font-bold text-slate-800 tracking-tight block leading-none">Kitchen Panel</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Aloha Dashboard</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 bg-green-50 px-3 py-1.5 rounded-full border border-green-100">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-green-600">Live Updates</span>
                </div>
                <a href="/admin/logout" class="bg-slate-100 hover:bg-red-50 hover:text-red-500 text-slate-500 p-2 rounded-lg transition" title="Logout">
                    <i class="ph-bold ph-sign-out text-xl"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="w-full px-6 py-8">
        
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-1">Antrian Pesanan</h1>
                <p class="text-slate-400 text-sm">Kelola status pesanan dari pelanggan secara real-time.</p>
            </div>
            <button @click="window.location.reload()" class="bg-white border border-slate-200 px-4 py-2 rounded-xl text-slate-600 font-bold text-sm hover:border-blue-500 hover:text-blue-600 transition shadow-sm flex items-center gap-2">
                <i class="ph-bold ph-arrows-clockwise text-lg"></i> Refresh
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <template x-for="order in orders" :key="order.id">
                <div @click="openModal(order)" 
                     class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 cursor-pointer group relative overflow-hidden flex flex-col h-full">
                    
                    <div class="absolute top-0 left-0 right-0 h-1.5"
                         :class="{
                            'bg-blue-500': order.status === 'Menunggu',
                            'bg-yellow-400': order.status === 'Dimasak',
                            'bg-green-500': order.status === 'Selesai',
                            'bg-red-500': order.status === 'Batal'
                         }"></div>

                    <div class="flex justify-between items-start mb-4 mt-2">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center font-bold text-slate-500 text-xl group-hover:bg-blue-600 group-hover:text-white transition" 
                                 x-text="order.customer_name.charAt(0)"></div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg leading-tight line-clamp-1" x-text="order.customer_name"></h3>
                                <p class="text-xs text-slate-400 font-bold mt-1 uppercase">Order #<span x-text="order.id"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-4 bg-slate-50 p-3 rounded-xl">
                        <div class="flex items-center gap-1.5">
                            <i class="ph-bold ph-clock text-slate-400"></i>
                            <span x-text="formatTime(order.created_at)"></span>
                        </div>
                        <div class="w-px h-4 bg-slate-300"></div>
                        <div class="flex items-center gap-1.5">
                            <i class="ph-bold ph-package text-slate-400"></i>
                            <span x-text="order.items.length + ' Item'"></span>
                        </div>
                    </div>

                    <div class="mt-auto flex justify-between items-center">
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold border"
                              :class="{
                                'bg-blue-50 text-blue-600 border-blue-100': order.status === 'Menunggu',
                                'bg-yellow-50 text-yellow-600 border-yellow-100': order.status === 'Dimasak',
                                'bg-green-50 text-green-600 border-green-100': order.status === 'Selesai',
                                'bg-red-50 text-red-600 border-red-100': order.status === 'Batal'
                              }" x-text="order.status"></span>
                        
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-500 group-hover:text-white transition">
                            <i class="ph-bold ph-caret-right"></i>
                        </div>
                    </div>
                </div>
            </template>
            
            <div x-show="orders.length === 0" class="col-span-full text-center py-32 text-slate-400 bg-white rounded-[2rem] border border-dashed border-slate-200">
                <i class="ph-duotone ph-coffee text-6xl mb-4 text-slate-200"></i>
                <h3 class="text-xl font-bold text-slate-500">Antrian Kosong</h3>
                <p>Belum ada pesanan masuk hari ini.</p>
            </div>
        </div>
    </div>

    <div x-show="selectedOrder" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="selectedOrder = null"></div>

        <div x-show="selectedOrder"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             class="bg-white w-full sm:max-w-md rounded-t-[2rem] sm:rounded-[2rem] p-6 shadow-2xl relative z-10 flex flex-col max-h-[90vh]">
            
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden shrink-0"></div>

            <div class="flex justify-between items-start mb-6 border-b border-dashed border-slate-200 pb-4">
                <div>
                    <h2 class="font-display font-bold text-2xl text-slate-900" x-text="selectedOrder?.customer_name"></h2>
                    <p class="text-sm text-slate-400">Order ID #<span x-text="selectedOrder?.id"></span></p>
                </div>
                <button @click="selectedOrder = null" class="bg-slate-50 p-2 rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition">
                    <i class="ph-bold ph-x text-xl"></i>
                </button>
            </div>

            <div class="flex-grow overflow-y-auto pr-2 mb-6 space-y-3 custom-scroll">
                <template x-for="item in selectedOrder?.items">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600 font-medium">
                            <span class="font-bold text-slate-900 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded text-xs mr-2" x-text="item.quantity + 'x'"></span> 
                            <span x-text="item.product_name"></span>
                        </span>
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

                <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Update Status Pesanan</label>
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
        function adminPanel(ordersData) {
            return {
                orders: ordersData,
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
                        } else { this.selectedOrder.status = oldStatus; alert('Gagal update status!'); }
                    } catch (e) { this.selectedOrder.status = oldStatus; alert('Error koneksi.'); }
                }
            }
        }
    </script>
</body>
</html>