<?php

return [
    /*
    | Keluhan per subkategori — disesuaikan dengan jenis jasa yang dipilih
    */
    'complaints_by_subcategory' => [
        'Service AC' => [
            'Service rutin / berkala',
            'AC tidak dingin',
            'AC bocor / tetes air',
            'AC berisik',
            'Bongkar / pasang AC',
            'AC mati total',
            'Lainnya',
        ],
        'Service Kulkas' => [
            'Kulkas tidak dingin',
            'Kompresor mati',
            'Kebocoran freon',
            'Service rutin',
            'Ganti sparepart',
            'Lainnya',
        ],
        'Service Mesin Cuci' => [
            'Mesin cuci tidak muter',
            'Tidak mengeluarkan air',
            'Berisik / getar',
            'Service rutin',
            'Mati total',
            'Lainnya',
        ],
        'Renovasi Rumah' => [
            'Renovasi total',
            'Renovasi kamar tidur',
            'Renovasi kamar mandi',
            'Renovasi dapur',
            'Perbaikan atap / bocor',
            'Konsultasi & survey',
            'Lainnya',
        ],
        'Kontraktor Bangunan' => [
            'Bangun rumah baru',
            'Renovasi besar',
            'Perlu RAB / estimasi',
            'Perpanjangan bangunan',
            'Lainnya',
        ],
        'Tukang Bangunan' => [
            'Perbaikan dinding / retak',
            'Pasang keramik',
            'Perbaikan plafon',
            'Pengecatan',
            'Pekerjaan harian (borongan)',
            'Lainnya',
        ],
        'Daily Cleaning' => [
            'Bersih rumah rutin',
            'Bersih apartemen',
            'Bersih kantor / ruko',
            'Setelah acara / pesta',
            'Butuh ART harian',
            'Lainnya',
        ],
        'Deep Cleaning' => [
            'Rumah jarang dibersihkan',
            'Pindahan / move in',
            'Setelah renovasi',
            'Bersih detail (seluruh ruangan)',
            'Anti tungau / alergi',
            'Lainnya',
        ],
        'Cuci Sofa' => [
            'Sofa berdebu / bau',
            'Noda membandel',
            'Cuci sofa fabric',
            'Cuci sofa kulit',
            'Cuci karpet / kasur',
            'Lainnya',
        ],
    ],

    'default_complaints' => [
        'Service rutin',
        'Butuh estimasi harga',
        'Butuh segera (urgent)',
        'Lainnya',
    ],

    'property_types' => [
        'rumah' => ['label' => 'Rumah', 'surcharge' => 0],
        'apartemen' => ['label' => 'Apartemen', 'surcharge' => 20000],
        'lainnya' => ['label' => 'Lainnya', 'surcharge' => 0],
    ],

    'cities' => [
        'Indonesia',
        'Jakarta',
        'Jakarta Selatan',
        'Jakarta Barat',
        'Bandung',
        'Surabaya',
        'Depok',
        'Tangerang',
        'Bekasi',
        'Bali',
        'Yogyakarta',
        'Semarang',
        'Medan',
    ],

    /*
    | Paket default per subkategori [nama, deskripsi, harga]
    */
    'default_packages' => [
        'Service AC' => [
            ['Cuci AC', 'Pembersihan unit AC standar', 150000],
            ['Perbaikan', 'Diagnosa & perbaikan ringan', 200000],
            ['Freon R32', 'Isi ulang freon R32', 175000],
            ['Freon R410', 'Isi ulang freon R410', 275000],
            ['Instalasi', 'Pasang AC baru (1 unit)', 350000],
        ],
        'Service Kulkas' => [
            ['Cuci & Service', 'Bersihkan kondensor & interior', 120000],
            ['Perbaikan', 'Perbaikan tidak dingin', 180000],
            ['Ganti Freon', 'Isi freon kulkas', 200000],
        ],
        'Service Mesin Cuci' => [
            ['Deep Clean', 'Pembersihan mesin cuci', 100000],
            ['Perbaikan', 'Perbaikan umum', 150000],
        ],
        'Renovasi Rumah' => [
            ['Konsultasi', 'Survey & estimasi awal', 0],
            ['Renovasi Kecil', '1–2 ruangan', 3000000],
            ['Renovasi Menengah', 'Beberapa ruangan', 8000000],
        ],
        'Kontraktor Bangunan' => [
            ['Konsultasi & RAB', 'Survey lokasi & estimasi', 500000],
            ['Paket Renovasi', 'Renovasi standar', 15000000],
        ],
        'Tukang Bangunan' => [
            ['Harial', 'Tukang harian', 200000],
            ['Borongan Kecil', 'Pekerjaan 1–3 hari', 750000],
            ['Pasang Keramik', 'Per m² (estimasi)', 150000],
        ],
        'Daily Cleaning' => [
            ['2 Jam', 'Cleaning rumah 2 jam', 150000],
            ['4 Jam', 'Cleaning rumah 4 jam', 280000],
            ['6 Jam', 'Cleaning rumah 6 jam', 400000],
        ],
        'Deep Cleaning' => [
            ['Rumah Kecil', 'Deep cleaning < 100m²', 450000],
            ['Rumah Besar', 'Deep cleaning > 100m²', 750000],
        ],
        'Cuci Sofa' => [
            ['1–2 Dudukan', 'Cuci sofa kecil', 150000],
            ['3–4 Dudukan', 'Cuci sofa sedang', 250000],
            ['Sofa L / Sectional', 'Cuci sofa besar', 400000],
            ['Cuci Karpet', 'Per unit karpet', 100000],
            ['Cuci Kasur', 'Per kasur', 120000],
        ],
    ],
];
