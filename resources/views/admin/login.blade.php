<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cordova - Admin login</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/img/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-[2rem] shadow-xl w-full max-w-sm border border-slate-100 text-center">
        <img src="/img/logo.png" class="h-20 mx-auto mb-4">
        <h1 class="font-['Fredoka'] text-2xl font-bold text-slate-800 mb-6">Admin Access 🔒</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 text-sm p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-4 text-left">
                <label class="text-xs font-bold text-slate-400 uppercase ml-1">Password</label>
                <input type="password" name="password" required 
                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-3 mt-1 focus:outline-none focus:border-blue-500 transition font-bold text-slate-800"
                    placeholder="Masukan password sakti...">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-500/30">
                Masuk Dashboard
            </button>
        </form>
        
        <a href="/" class="block mt-6 text-sm text-slate-400 hover:text-slate-600">← Kembali ke Menu</a>
    </div>

</body>
</html>