<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        .container { max-width: 700px; margin: 40px auto; padding: 20px; }
        .card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; }
        .btn-secondary { background: #6b7280; }
        .detail { margin: 14px 0; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detail Produk</h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="detail"><span class="label">Nama:</span> {{ $product->name }}</div>
            <div class="detail"><span class="label">Kategori:</span> {{ $product->category->name ?? '-' }}</div>
            <div class="detail"><span class="label">SKU:</span> {{ $product->sku }}</div>
            <div class="detail"><span class="label">Harga:</span> Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="detail"><span class="label">Stok:</span> {{ $product->stock }}</div>
        </div>
    </div>
</body>
</html>
