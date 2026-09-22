<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Toko</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f4f7fb, #eaf4ef);
            color: #1f2937;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 24px;
        }
        .header {
            margin-bottom: 24px;
        }
        .header h1 {
            margin: 0 0 8px;
            font-size: 32px;
        }
        .header p {
            margin: 0;
            color: #4b5563;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }
        .label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }
        .grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
        }
        .section-title {
            font-size: 20px;
            margin: 0 0 16px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .badge {
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .product-name {
            font-weight: 600;
        }
        .muted {
            color: #6b7280;
            font-size: 13px;
        }
        .price {
            color: #2563eb;
            font-weight: 700;
        }
        @media (max-width: 768px) {
            .stats, .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard Toko</h1>
            <p>Ringkasan data produk, kategori, dan supplier</p>
        </div>

        <div class="stats">
            <div class="card">
                <div class="label">Kategori</div>
                <div class="value">{{ $categories->count() }}</div>
            </div>
            <div class="card">
                <div class="label">Produk</div>
                <div class="value">{{ $products->count() }}</div>
            </div>
            <div class="card">
                <div class="label">Supplier</div>
                <div class="value">{{ $suppliers->count() }}</div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h2 class="section-title">Daftar Kategori</h2>
                <ul>
                    @foreach ($categories as $category)
                        <li class="list-item">
                            <span>{{ $category->name }}</span>
                            <span class="badge">{{ $category->slug }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2 class="section-title">Supplier</h2>
                <ul>
                    @foreach ($suppliers as $supplier)
                        <li class="list-item">
                            <div>
                                <div>{{ $supplier->name }}</div>
                                <div class="muted">{{ $supplier->phone }}</div>
                            </div>
                            <span class="muted">{{ Str::limit($supplier->address, 22) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2 class="section-title">Produk Terbaru</h2>
            <ul>
                @foreach ($products as $product)
                    <li class="product-item">
                        <div>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="muted">{{ $product->category->name ?? 'Tanpa Kategori' }} • SKU: {{ $product->sku }}</div>
                        </div>
                        <div>
                            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="muted">Stok: {{ $product->stock }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>
</html>
