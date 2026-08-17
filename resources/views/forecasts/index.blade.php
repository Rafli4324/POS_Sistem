@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peramalan Penjualan & Stok</h1>
            <p class="text-sm text-gray-500 mt-1">Dukung keputusan penyediaan bahan baku menggunakan model Simple Moving Average (SMA).</p>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('forecasts.manual') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                @csrf
                <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls" onchange="this.form.submit()">
                <label for="excel_file" class="cursor-pointer px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-all shadow-sm flex items-center mr-2">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Excel
                </label>
            </form>
            <form action="{{ route('forecasts.generate') }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Generate Prediksi
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if(isset($topMenu))
    <div class="mb-6 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-xl shadow-lg p-6 text-white flex items-center justify-between">
        <div>
            <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-100 mb-1">Rekomendasi Menu Paling Laku Besok</h2>
            <p class="text-3xl font-extrabold">{{ $topMenu->menu->nama_menu }}</p>
            <p class="mt-2 text-indigo-100">Diprediksi akan terjual sebanyak <span class="font-bold text-white">{{ $topMenu->prediksi_terjual }} porsi</span>.</p>
        </div>
        <div class="hidden sm:block">
            <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Prediksi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prediksi (SMA)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Error (MAD/MSE)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Saran Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($forecasts as $forecast)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($forecast->tanggal_prediksi)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $forecast->menu->nama_menu }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $forecast->menu->stok_saat_ini }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="font-bold text-indigo-600">{{ $forecast->prediksi_terjual }} porsi</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            MAD: <span class="font-medium text-gray-700">{{ number_format($forecast->mad, 2) }}</span><br>
                            MSE: <span class="font-medium text-gray-700">{{ number_format($forecast->mse, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($forecast->saran_aksi == 'Tambah Stok')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $forecast->saran_aksi }} (+{{ $forecast->rekomendasi_stok_tambahan }})
                                </span>
                            @elseif($forecast->saran_aksi == 'Kurangi Stok')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $forecast->saran_aksi }}
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $forecast->saran_aksi }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-sm">
                            Belum ada data peramalan. Silakan klik tombol "Generate Prediksi Besok".
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($forecasts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $forecasts->links() }}
        </div>
        @endif
    </div>
</div>

    @if(session('manual_result'))
    <!-- Modal Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity z-50 flex justify-center items-center backdrop-blur-sm" id="manualModal">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-4 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Hasil Prediksi Manual (SMA via Excel)</h3>
                <button onclick="document.getElementById('manualModal').style.display='none'" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Menu</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Stok Inventori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prediksi SMA</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Error (MAD/MSE)</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Saran Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(session('manual_result')['predictions'] as $pred)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $pred['menu_nama'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $pred['stok_saat_ini'] }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-indigo-600">{{ $pred['prediksi'] }} porsi</td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                MAD: <span class="font-medium text-gray-700">{{ number_format($pred['mad'], 2) }}</span><br>
                                MSE: <span class="font-medium text-gray-700">{{ number_format($pred['mse'], 2) }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($pred['saran_aksi'] == 'Tambah Stok')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $pred['saran_aksi'] }} (+{{ $pred['rekomendasi_stok_tambahan'] }})
                                    </span>
                                @elseif($pred['saran_aksi'] == 'Kurangi Stok')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $pred['saran_aksi'] }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $pred['saran_aksi'] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-right">
                <button onclick="document.getElementById('manualModal').style.display='none'" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Tutup</button>
            </div>
        </div>
    </div>
    @endif
@endsection
