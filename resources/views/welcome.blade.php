<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Aloha! - Order</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/img/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased pb-32 selection:bg-electricOrange selection:text-white" x-data="foodOrder()">

    <button @click="isQueueModalOpen = true" class="fixed top-4 right-4 z-30 bg-white p-3 rounded-full shadow-lg border border-slate-100 text-electricBlue hover:bg-electricBlue hover:text-white transition active:scale-90 group">
        <i class="ph-bold ph-list-numbers text-2xl group-hover:rotate-12 transition"></i>
        <span class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-electricOrange opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-electricOrange"></span>
        </span>
    </button>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-7xl overflow-x-hidden">
        
        <header class="text-center mb-8 pt-2 relative">
            <div class="inline-block relative group cursor-pointer transform transition hover:scale-105 duration-300">
                <i class="ph-fill ph-sun text-4xl sm:text-6xl text-yellow-400 absolute -top-4 -right-4 sm:-top-8 sm:-right-12 animate-spin-slow z-0"></i>
                <img src="/img/logo.png" alt="Aloha Wi Logo" class="h-24 sm:h-42 md:h-48 lg:h-56 w-auto mx-auto object-contain relative z-10 drop-shadow-sm filter hover:brightness-110 transition">
                <p class="font-display text-electricOrange text-sm sm:text-lg md:text-xl tracking-[0.2em] mt-2 uppercase font-bold">Summer Dream's</p>
            </div>
        </header>

        <div class="relative -mx-4 px-4 sm:mx-0 sm:px-0 mb-6 group">
            <div class="flex sm:justify-center gap-3 overflow-x-auto no-scrollbar pb-4 snap-x">
                <template x-for="cat in ['All', 'Rice', 'Noodles', 'Drinks', 'Dessert', 'Snacks']">
                    <button class="snap-start shrink-0 px-5 py-2.5 rounded-full font-display font-bold border-2 transition-all duration-200 text-sm sm:text-base whitespace-nowrap"
                        :class="activeCategory === cat ? 'bg-electricBlue border-electricBlue text-white shadow-fun-blue translate-y-[-2px]' : 'bg-white border-slate-100 text-slate-400 hover:border-electricBlue hover:text-electricBlue'">
                        <span x-text="cat"></span>
                    </button>
                </template>
            </div>
            <div class="absolute right-0 top-0 bottom-4 w-8 bg-gradient-to-l from-white to-transparent sm:hidden pointer-events-none"></div>
        </div>

        <div class="grid grid-cols-1 min-[500px]:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            <template x-for="item in items" :key="item.id">
                <div class="group bg-white border-2 border-slate-100 rounded-[2rem] p-4 flex flex-row sm:flex-col items-center gap-4 sm:gap-0 hover:border-electricBlue transition-all duration-300 hover:shadow-xl relative overflow-hidden h-full">
                    <div class="shrink-0 w-24 h-24 sm:w-40 sm:h-40 md:w-48 md:h-48 rounded-2xl sm:rounded-full overflow-hidden border-2 sm:border-4 border-slate-50 shadow-inner sm:mb-4 sm:mt-2 group-hover:scale-105 transition-transform duration-500">
                        <img :src="item.image" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow sm:text-center w-full flex flex-col justify-between sm:h-full">
                        <div>
                            <h3 class="font-display font-bold text-lg sm:text-xl text-slate-800 leading-tight mb-1" x-text="item.name"></h3>
                            <p class="text-xs sm:text-sm text-slate-400 mb-2 sm:mb-4 line-clamp-2">Deskripsi menu yang lezat & bergizi.</p>
                        </div>
                        <div class="flex sm:block items-center justify-between sm:mt-auto w-full">
                            <p class="font-display font-bold text-lg sm:text-2xl text-electricBlue sm:mb-3" x-text="formatRupiah(item.price)"></p>
                            <button @click="openQtyModal(item)" class="bg-white border-2 border-electricOrange text-electricOrange font-display font-bold py-2 px-4 sm:py-3 sm:w-full rounded-xl sm:rounded-2xl hover:bg-electricOrange hover:text-white transition-all active:scale-95 shadow-fun-orange flex items-center gap-1">
                                <span class="hidden sm:inline">ADD</span> <i class="ph-bold ph-plus text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div x-show="cart.length > 0" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         class="fixed bottom-4 left-4 right-4 z-40">
        <div class="container mx-auto max-w-xl">
            <button @click="openCartModal()" class="w-full bg-slate-900 text-white rounded-[2rem] p-2 pr-3 sm:p-3 sm:pl-4 shadow-2xl flex items-center justify-between hover:scale-[1.01] transition-transform ring-4 ring-white group">
                <div class="flex items-center gap-3 sm:gap-4 pl-2">
                    <div class="bg-electricOrange w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-display font-bold text-lg sm:text-xl text-white shadow-lg animate-bounce-short shrink-0">
                        <span x-text="totalItems"></span>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] sm:text-xs text-slate-400 uppercase font-bold tracking-wider">Total</span>
                        <span class="font-display font-bold text-lg sm:text-2xl leading-none" x-text="formatRupiah(totalPrice)"></span>
                    </div>
                </div>
                <div class="bg-electricBlue text-white px-5 sm:px-8 py-3 sm:py-3 rounded-[1.5rem] font-display font-bold text-sm sm:text-lg group-hover:bg-blue-600 transition shadow-lg flex items-center gap-2">
                    VIEW CART <i class="ph-bold ph-shopping-cart"></i>
                </div>
            </button>
        </div>
    </div>

    <div x-show="isQtyModalOpen" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="closeQtyModal()"></div>
        <div x-show="isQtyModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:opacity-0 sm:scale-90"
             x-transition:enter-end="translate-y-0 sm:opacity-100 sm:scale-100"
             class="bg-white w-full sm:max-w-sm rounded-t-[2.5rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-2xl relative z-10">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden"></div>
            <div class="text-center">
                <img :src="selectedItem?.image" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full mx-auto mb-4 border-4 border-slate-100 shadow-md object-cover">
                <h3 class="font-display font-bold text-xl sm:text-2xl text-slate-800 leading-tight" x-text="selectedItem?.name"></h3>
                <p class="text-electricBlue font-bold text-xl mt-1" x-text="formatRupiah(selectedItem?.price)"></p>
            </div>
            <div class="flex items-center justify-center gap-6 my-6 sm:my-8 bg-slate-50 py-3 sm:py-4 rounded-2xl border border-slate-100">
                <button @click="if(tempQty > 1) tempQty--" class="w-10 h-10 rounded-full bg-white shadow border border-slate-200 flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition active:scale-90"><i class="ph-bold ph-minus"></i></button>
                <span class="font-display font-bold text-3xl text-slate-800 w-10 text-center" x-text="tempQty"></span>
                <button @click="tempQty++" class="w-10 h-10 rounded-full bg-slate-900 text-white shadow flex items-center justify-center hover:bg-electricBlue transition active:scale-90"><i class="ph-bold ph-plus"></i></button>
            </div>
            <button @click="addToCart()" class="w-full bg-electricOrange text-white font-display font-bold py-4 rounded-2xl shadow-fun-orange active:translate-y-1 active:shadow-none transition-all text-lg">
                Simpan (<span x-text="formatRupiah(selectedItem?.price * tempQty)"></span>)
            </button>
        </div>
    </div>

    <div x-show="isCartModalOpen" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="isCartModalOpen = false"></div>
        <div x-show="isCartModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             class="bg-white w-full sm:max-w-md h-[85vh] sm:h-auto rounded-t-[2.5rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-2xl overflow-hidden relative z-10 flex flex-col">
             <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden shrink-0"></div>
            <div class="flex justify-between items-center mb-6 shrink-0">
                <h2 class="font-display font-bold text-2xl text-slate-900">Keranjang Kamu 🛒</h2>
                <button @click="isCartModalOpen = false" class="text-slate-400 hover:text-red-500 bg-slate-50 p-2 rounded-full"><i class="ph-bold ph-x text-xl"></i></button>
            </div>
            <div class="flex-grow overflow-y-auto pr-1 space-y-4">
                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex gap-4 items-center bg-white border border-slate-100 rounded-2xl p-3 shadow-sm">
                        <div class="w-16 h-16 rounded-xl overflow-hidden border border-slate-100 shrink-0">
                            <img :src="item.image" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-display font-bold text-slate-800 text-sm leading-tight line-clamp-1" x-text="item.name"></h4>
                                <button @click="removeFromCart(index)" class="text-slate-300 hover:text-red-500 p-1"><i class="ph-fill ph-trash text-lg"></i></button>
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="text-electricBlue font-bold text-sm" x-text="formatRupiah(item.price * item.qty)"></p>
                                <div class="flex items-center gap-3 bg-slate-50 rounded-full px-2 py-1 border border-slate-100">
                                    <button @click="decreaseQty(index)" class="w-6 h-6 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-500 hover:bg-slate-100 text-xs shadow-sm"><i class="ph-bold ph-minus"></i></button>
                                    <span class="font-bold text-sm min-w-[1rem] text-center" x-text="item.qty"></span>
                                    <button @click="increaseQty(index)" class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-800 text-white hover:bg-black text-xs shadow-sm"><i class="ph-bold ph-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="text-center py-10">
                    <i class="ph-duotone ph-shopping-cart text-6xl text-slate-200 mb-2"></i>
                    <p class="text-slate-400 font-medium">Keranjang masih kosong nih!</p>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 shrink-0">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-slate-500">Total</span>
                    <span class="font-display font-bold text-2xl text-electricBlue" x-text="formatRupiah(totalPrice)"></span>
                </div>
                <button @click="openCheckoutForm()" class="w-full bg-electricOrange text-white font-display font-bold py-4 rounded-2xl shadow-fun-orange active:translate-y-1 active:shadow-none hover:bg-[#e55a00] transition-all flex items-center justify-center gap-2 text-lg">
                    Lanjut Pembayaran <i class="ph-bold ph-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isFormModalOpen" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="isFormModalOpen = false"></div>
        <div x-show="isFormModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             class="bg-white w-full sm:max-w-md h-[90vh] sm:h-auto rounded-t-[2.5rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-2xl overflow-y-auto relative z-10 flex flex-col">
             <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden shrink-0"></div>
            <div class="flex justify-between items-center mb-6 shrink-0">
                <h2 class="font-display font-bold text-2xl text-slate-900">Data Pemesan 📝</h2>
                <button @click="isFormModalOpen = false" class="text-slate-400 hover:text-red-500 bg-slate-50 p-2 rounded-full"><i class="ph-bold ph-arrow-left text-xl"></i></button>
            </div>
            <div class="flex-grow overflow-y-auto pr-1">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Nama Kamu</label>
                        <input type="text" x-model="customerName" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-5 py-4 font-bold text-slate-800 focus:outline-none focus:border-electricBlue transition placeholder-slate-300" placeholder="Siapa nama kamu?">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Catatan</label>
                        <textarea x-model="customerNotes" rows="3" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-5 py-4 font-medium text-slate-800 focus:outline-none focus:border-electricBlue transition placeholder-slate-300" placeholder="Contoh: Jangan pedes ya..."></textarea>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 shrink-0">
                <button @click="processOrder()" class="w-full bg-[#25D366] text-white font-display font-bold py-4 rounded-2xl shadow-[0_6px_0_0_#1DA851] active:translate-y-1 active:shadow-none hover:bg-[#22bf5b] transition-all flex items-center justify-center gap-3 text-lg">
                    <i class="ph-bold ph-whatsapp-logo text-2xl"></i>
                    Kirim ke WhatsApp
                </button>
            </div>
        </div>
    </div>

    <div x-show="isQueueModalOpen" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="absolute inset-0" @click="isQueueModalOpen = false; selectedQueueItem = null"></div>

        <div x-show="isQueueModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             class="bg-white w-full sm:max-w-md h-[90vh] sm:h-[80vh] rounded-t-[2.5rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-2xl overflow-hidden relative z-10 flex flex-col">
            
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6 sm:hidden shrink-0"></div>

            <div class="flex justify-between items-center mb-6 shrink-0">
                <h2 class="font-display font-bold text-2xl text-slate-900 flex items-center gap-2">
                    Live Queue <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full animate-pulse">LIVE</span>
                </h2>
                <button @click="isQueueModalOpen = false; selectedQueueItem = null" class="text-slate-400 hover:text-red-500 bg-slate-50 p-2 rounded-full"><i class="ph-bold ph-x text-xl"></i></button>
            </div>

            <div x-show="!selectedQueueItem" class="flex-grow overflow-y-auto pr-1 space-y-3" x-transition:enter="transition ease-out duration-200">
                <p class="text-sm text-slate-400 mb-2">Klik nama untuk lihat detail pesanan.</p>
                
                <template x-for="q in queueList" :key="q.id">
                    <div @click="selectedQueueItem = q" class="bg-white border-2 border-slate-50 rounded-2xl p-4 flex items-center justify-between hover:border-electricBlue cursor-pointer transition shadow-sm group">
                        <div class="flex items-center gap-4">
                            <div class="bg-slate-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-slate-500 group-hover:bg-electricBlue group-hover:text-white transition" x-text="q.name.charAt(0)"></div>
                            <div>
                                <h4 class="font-bold text-slate-800" x-text="q.name"></h4>
                                <div class="flex items-center gap-2 text-xs font-medium mt-1">
                                    <span class="px-2 py-0.5 rounded-full" 
                                        :class="{
                                            'bg-green-100 text-green-600': q.status === 'Selesai',
                                            'bg-yellow-100 text-yellow-600': q.status === 'Dimasak',
                                            'bg-slate-100 text-slate-500': q.status === 'Menunggu'
                                        }" 
                                        x-text="q.status">
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-slate-400" x-text="q.time"></span>
                                </div>
                            </div>
                        </div>
                        <i class="ph-bold ph-caret-right text-slate-300 group-hover:text-electricBlue"></i>
                    </div>
                </template>
            </div>

            <div x-show="selectedQueueItem" class="flex-grow overflow-y-auto pr-1 flex flex-col h-full" x-transition:enter="transition ease-out duration-200">
                <button @click="selectedQueueItem = null" class="flex items-center gap-2 text-slate-400 hover:text-electricBlue font-bold text-sm mb-4">
                    <i class="ph-bold ph-arrow-left"></i> Kembali
                </button>

                <div class="bg-slate-50 rounded-[2rem] p-6 text-center mb-6">
                    <h3 class="font-display font-bold text-2xl text-slate-900 mb-1" x-text="selectedQueueItem?.name"></h3>
                    <p class="text-slate-400 text-sm mb-4">Total Pesanan: <span class="font-bold text-electricBlue" x-text="formatRupiah(selectedQueueItem?.total)"></span></p>
                    <span class="px-4 py-2 rounded-full font-bold text-sm"
                        :class="{
                            'bg-green-100 text-green-600': selectedQueueItem?.status === 'Selesai',
                            'bg-yellow-100 text-yellow-600': selectedQueueItem?.status === 'Dimasak',
                            'bg-slate-100 text-slate-500': selectedQueueItem?.status === 'Menunggu'
                        }" 
                        x-text="selectedQueueItem?.status">
                    </span>
                </div>

                <h4 class="font-bold text-slate-800 mb-3">Menu Dipesan:</h4>
                <div class="space-y-3">
                    <template x-for="item in selectedQueueItem?.items">
                        <div class="flex justify-between items-center border-b border-dashed border-slate-200 pb-2">
                            <span class="text-slate-600 font-medium"><span class="font-bold text-slate-900 mr-2" x-text="item.qty + 'x'"></span> <span x-text="item.name"></span></span>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('foodOrder', () => ({
                activeCategory: 'All',
                cart: [],
                items: [
                    { id: 1, name: 'Berry Manuka', price: 27000, image: '/img/manuka.png' },
                    { id: 2, name: 'Choco Lava Bun', price: 21000, image: '/img/bun.png' },
                    { id: 3, name: 'Sparkling Lychee Tea', price: 23000, image: '/img/lychee.png' },
                    { id: 4, name: 'Magic Water', price: 16000, image: '/img/magic.png' },
                    { id: 5, name: 'Fruiti Punch', price: 28000, image: '/img/fruiti.png' },
                    { id: 6, name: 'Choco Lava Cake', price: 22000, image: 'https://images.unsplash.com/photo-1606313564200-e75d5e30476d?w=500&q=80' }
                ],
                
                // DATA DUMMY ANTRIAN (Nanti diganti pake database)
                queueList: [
                    { 
                        id: 101, name: 'Kak Rina', time: '10:05', status: 'Selesai', total: 53000, 
                        items: [{name: 'Crazy Rich Rice Bowl', qty: 1}, {name: 'Fresh Mango Juice', qty: 1}] 
                    },
                    { 
                        id: 102, name: 'Bang Jago', time: '10:12', status: 'Dimasak', total: 85000, 
                        items: [{name: 'Mega Steak & Fries', qty: 1}] 
                    },
                    { 
                        id: 103, name: 'Sisil', time: '10:15', status: 'Menunggu', total: 22000, 
                        items: [{name: 'Choco Lava Cake', qty: 1}] 
                    },
                    { 
                        id: 104, name: 'Pak Budi', time: '10:20', status: 'Menunggu', total: 70000, 
                        items: [{name: 'Crazy Rich Rice Bowl', qty: 2}] 
                    },
                ],

                // Modal States
                isQtyModalOpen: false,
                isCartModalOpen: false,
                isFormModalOpen: false,
                isQueueModalOpen: false, // State Modal Antrian
                
                selectedItem: null,
                selectedQueueItem: null, // State Detail Antrian
                tempQty: 1,
                customerName: '',
                customerNotes: '',

                get totalItems() { return this.cart.reduce((a, b) => a + b.qty, 0) },
                get totalPrice() { return this.cart.reduce((a, b) => a + (b.price * b.qty), 0) },

                formatRupiah(val) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val || 0);
                },

                // ADD ITEM FLOW
                openQtyModal(item) {
                    this.selectedItem = item;
                    this.tempQty = 1;
                    this.isQtyModalOpen = true;
                },

                closeQtyModal() {
                    this.isQtyModalOpen = false;
                    this.selectedItem = null;
                },

                addToCart() {
                    let existing = this.cart.find(i => i.id === this.selectedItem.id);
                    if(existing) {
                        existing.qty += this.tempQty;
                    } else {
                        this.cart.push({ ...this.selectedItem, qty: this.tempQty });
                    }
                    this.closeQtyModal();
                },

                // MANAGE CART FLOW
                openCartModal() {
                    this.isCartModalOpen = true;
                },

                increaseQty(index) {
                    this.cart[index].qty++;
                },

                decreaseQty(index) {
                    if(this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    } else {
                        if(confirm('Hapus item ini dari keranjang?')) {
                            this.removeFromCart(index);
                        }
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    if(this.cart.length === 0) {
                        this.isCartModalOpen = false;
                        this.isFormModalOpen = false;
                    }
                },

                // CHECKOUT FLOW
                openCheckoutForm() {
                    this.isCartModalOpen = false;
                    setTimeout(() => {
                        this.isFormModalOpen = true;
                    }, 200);
                },

                processOrder() {
                    if(!this.customerName) {
                        alert('Eits, namanya diisi dulu dong kakak! 😄');
                        return;
                    }

                    let text = `*ALOHA! NEW ORDER* 🌴%0A%0A`;
                    text += `👤 *Nama:* ${this.customerName}%0A`;
                    text += `📝 *Notes:* ${this.customerNotes || '-' }%0A%0A`;
                    text += `*----- DAFTAR PESANAN -----*%0A`;
                    
                    this.cart.forEach((item, i) => {
                        text += `${i+1}. ${item.name} (${item.qty}x) - ${this.formatRupiah(item.price * item.qty)}%0A`;
                    });
                    
                    text += `%0A-----------------------------%0A`;
                    text += `💰 *TOTAL: ${this.formatRupiah(this.totalPrice)}*`;

                    let waNumber = "6281234567890"; 
                    window.open(`https://wa.me/${waNumber}?text=${text}`, '_blank');
                }
            }));
        });
    </script>
</body>
</html>