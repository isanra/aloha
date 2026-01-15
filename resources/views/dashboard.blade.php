<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order</title>
    
    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        electricBlue: '#2563EB',  /* Tailwind Blue-600 */
                        electricOrange: '#F97316', /* Tailwind Orange-500 */
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Hide scrollbar for category list */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased pb-24" x-data="foodOrder()">

    <div class="max-w-md mx-auto bg-white min-h-screen relative shadow-2xl overflow-hidden">
        
        <header class="px-6 pt-8 pb-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-slate-900">Menu</h1>
                <button class="text-slate-400 hover:text-electricBlue transition">
                    <i class="ph ph-list text-2xl"></i>
                </button>
            </div>

            <div class="relative group">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-electricBlue transition"></i>
                <input type="text" placeholder="What would you like to eat?" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-full py-3.5 pl-12 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-electricBlue/20 focus:border-electricBlue transition shadow-sm">
            </div>
        </header>

        <div class="px-6 mb-8">
            <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2">
                <button class="bg-slate-900 text-white px-6 py-2.5 rounded-full text-sm font-medium shrink-0 shadow-lg shadow-slate-900/20">All</button>
                <button class="bg-slate-50 text-slate-500 px-6 py-2.5 rounded-full text-sm font-medium shrink-0 hover:bg-electricBlue/10 hover:text-electricBlue transition">Business menu</button>
                <button class="bg-slate-50 text-slate-500 px-6 py-2.5 rounded-full text-sm font-medium shrink-0 hover:bg-electricBlue/10 hover:text-electricBlue transition">Breakfast</button>
                <button class="bg-slate-50 text-slate-500 px-6 py-2.5 rounded-full text-sm font-medium shrink-0 hover:bg-electricBlue/10 hover:text-electricBlue transition">Dessert</button>
            </div>
        </div>

        <section class="px-6">
            <div class="flex justify-between items-end mb-4">
                <h2 class="text-xl font-bold text-slate-900">Top rated</h2>
                <button class="text-electricOrange text-sm font-medium hover:underline">Filter</button>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <template x-for="item in items" :key="item.id">
                    <div class="group">
                        <div class="relative mb-3">
                            <div class="rounded-full overflow-hidden aspect-square shadow-lg mb-3 border-4 border-white group-hover:scale-105 transition duration-300">
                                <img :src="item.image" alt="Food" class="w-full h-full object-cover">
                            </div>
                            <button class="absolute top-0 right-0 bg-white p-2 rounded-full shadow-sm text-slate-400 hover:text-red-500 transition">
                                <i class="ph ph-heart text-lg"></i>
                            </button>
                        </div>
                        
                        <h3 class="font-bold text-slate-900 leading-tight mb-1 h-10 overflow-hidden" x-text="item.name"></h3>
                        
                        <div class="flex items-center gap-3 text-xs text-slate-500 mb-3">
                            <span class="flex items-center gap-1"><i class="ph ph-clock"></i> <span x-text="item.time"></span></span>
                            <span class="flex items-center gap-1 text-yellow-500"><i class="ph-fill ph-star"></i> <span x-text="item.rating" class="text-slate-700 font-medium"></span></span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-900" x-text="formatRupiah(item.price)"></span>
                            <button @click="openQuantityModal(item)" 
                                class="bg-electricOrange text-white px-4 py-1.5 rounded-full text-sm font-medium shadow-lg shadow-electricOrange/30 hover:bg-orange-600 active:scale-95 transition">
                                Add
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white border-t border-slate-100 px-6 py-3 flex justify-between items-center z-10 text-xs font-medium text-slate-400">
            <button class="flex flex-col items-center gap-1 text-slate-900">
                <i class="ph-fill ph-house text-2xl"></i>
                <span>Home</span>
            </button>
            <button class="flex flex-col items-center gap-1 hover:text-electricBlue">
                <i class="ph ph-book-open-text text-2xl"></i>
                <span>Menu</span>
            </button>
            <div class="w-10"></div> <button class="flex flex-col items-center gap-1 hover:text-electricBlue">
                <i class="ph ph-shopping-cart text-2xl"></i>
                <span>Cart</span>
            </button>
            <button class="flex flex-col items-center gap-1 hover:text-electricBlue">
                <i class="ph ph-user text-2xl"></i>
                <span>Profile</span>
            </button>
        </nav>

        <div x-show="cart.length > 0" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed bottom-20 left-4 right-4 max-w-[416px] mx-auto z-20">
            <button @click="openCheckoutModal()" class="w-full bg-slate-900 text-white p-4 rounded-2xl shadow-xl flex justify-between items-center hover:bg-slate-800 transition group">
                <div class="flex items-center gap-3">
                    <div class="bg-electricOrange w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold" x-text="totalItems"></div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400">Total</p>
                        <p class="font-bold text-lg" x-text="formatRupiah(totalPrice)"></p>
                    </div>
                </div>
                <div class="flex items-center gap-2 pr-2">
                    <span class="font-semibold">Order Now</span>
                    <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition"></i>
                </div>
            </button>
        </div>

        <div x-show="isQtyModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-end justify-center sm:items-center bg-black/40 backdrop-blur-sm" x-cloak>
            <div @click.outside="isQtyModalOpen = false" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-10 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl">
                
                <div class="w-12 h-1 bg-slate-200 rounded-full mx-auto mb-6"></div>
                
                <div class="flex gap-4 mb-6">
                    <img :src="selectedItem?.image" class="w-24 h-24 rounded-2xl object-cover shadow-md">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900" x-text="selectedItem?.name"></h3>
                        <p class="text-electricBlue font-bold text-lg mt-1" x-text="formatRupiah(selectedItem?.price)"></p>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-6">
                    <span class="font-medium text-slate-600">Jumlah Porsi</span>
                    <div class="flex items-center gap-4">
                        <button @click="if(tempQty > 1) tempQty--" class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100"><i class="ph-bold ph-minus"></i></button>
                        <span class="font-bold text-lg w-4 text-center" x-text="tempQty"></span>
                        <button @click="tempQty++" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-slate-700"><i class="ph-bold ph-plus"></i></button>
                    </div>
                </div>

                <button @click="addToCart()" class="w-full bg-electricOrange text-white font-bold py-4 rounded-xl shadow-lg shadow-electricOrange/30 active:scale-95 transition">
                    Simpan ke Pesanan
                </button>
            </div>
        </div>

        <div x-show="isCheckoutModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-end justify-center sm:items-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div @click.outside="isCheckoutModalOpen = false" 
                 class="bg-white w-full max-w-md rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl h-[80vh] overflow-y-auto">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Detail Pesanan</h2>
                    <button @click="isCheckoutModalOpen = false" class="text-slate-400 hover:text-red-500"><i class="ph-bold ph-x text-xl"></i></button>
                </div>

                <div class="space-y-4 mb-6">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <div>
                                <p class="font-bold text-sm text-slate-900" x-text="item.name"></p>
                                <p class="text-xs text-slate-500"><span x-text="item.qty"></span> x <span x-text="formatRupiah(item.price)"></span></p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-sm text-electricBlue" x-text="formatRupiah(item.price * item.qty)"></span>
                                <button @click="removeFromCart(index)" class="text-red-400 hover:text-red-600"><i class="ph-fill ph-trash"></i></button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-between items-center mb-8 pt-2 border-t border-slate-200">
                    <span class="font-bold text-slate-900">Total Bayar</span>
                    <span class="font-bold text-xl text-electricOrange" x-text="formatRupiah(totalPrice)"></span>
                </div>

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Pemesan</label>
                        <input type="text" x-model="customerName" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-electricBlue focus:outline-none" placeholder="Contoh: Budi Santoso">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan Tambahan</label>
                        <textarea x-model="customerNote" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-electricBlue focus:outline-none" placeholder="Contoh: Jangan pedes ya, kuah dipisah..."></textarea>
                    </div>
                </div>

                <button @click="sendToWhatsapp()" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-500/30 flex justify-center items-center gap-2 transition">
                    <i class="ph-bold ph-whatsapp-logo text-xl"></i>
                    Kirim Pesanan
                </button>
            </div>
        </div>

    </div>

    <script>
        function foodOrder() {
            return {
                // Data Produk Dummy
                items: [
                    { id: 1, name: 'Rice with Chicken and Vege Salsa', price: 25000, time: '10 min', rating: 4.9, image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' },
                    { id: 2, name: 'Salad with Tuna and Mustard', price: 32000, time: '8 min', rating: 4.5, image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' },
                    { id: 3, name: 'Beef Ramen Special Egg', price: 45000, time: '15 min', rating: 4.8, image: 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' },
                    { id: 4, name: 'Steak with Potato Wedges', price: 85000, time: '20 min', rating: 5.0, image: 'https://images.unsplash.com/photo-1600891964092-4316c288032e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' },
                ],
                
                // State Logic
                cart: [],
                isQtyModalOpen: false,
                isCheckoutModalOpen: false,
                selectedItem: null,
                tempQty: 1,
                customerName: '',
                customerNote: '',

                // Computed Properties (di Alpine pakai getter)
                get totalItems() {
                    return this.cart.reduce((acc, item) => acc + item.qty, 0);
                },
                get totalPrice() {
                    return this.cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
                },

                // Functions
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                },

                openQuantityModal(item) {
                    this.selectedItem = item;
                    this.tempQty = 1;
                    this.isQtyModalOpen = true;
                },

                addToCart() {
                    // Cek jika item sudah ada di cart
                    const existingItem = this.cart.find(i => i.id === this.selectedItem.id);
                    
                    if (existingItem) {
                        existingItem.qty += this.tempQty;
                    } else {
                        this.cart.push({
                            ...this.selectedItem,
                            qty: this.tempQty
                        });
                    }
                    
                    this.isQtyModalOpen = false;
                    // Reset selected
                    this.selectedItem = null;
                },

                openCheckoutModal() {
                    this.isCheckoutModalOpen = true;
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    if(this.cart.length === 0) this.isCheckoutModalOpen = false;
                },

                sendToWhatsapp() {
                    if(!this.customerName) {
                        alert("Mohon isi nama Anda");
                        return;
                    }

                    let message = `*Halo, saya mau pesan makanan:*%0A%0A`;
                    message += `Nama: ${this.customerName}%0A`;
                    message += `Catatan: ${this.customerNote}%0A%0A`;
                    message += `*Detail Pesanan:*%0A`;
                    
                    this.cart.forEach((item, index) => {
                        message += `${index+1}. ${item.name} (${item.qty}x) - ${this.formatRupiah(item.price * item.qty)}%0A`;
                    });

                    message += `%0A*Total Bayar: ${this.formatRupiah(this.totalPrice)}*`;

                    // Ganti nomor WA tujuan di sini (Format 628...)
                    const phoneNumber = "6281234567890"; 
                    const url = `https://wa.me/${phoneNumber}?text=${message}`;
                    
                    window.open(url, '_blank');
                }
            }
        }
    </script>
</body>
</html>