<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        .container { max-width: 700px; margin: 40px auto; padding: 20px; }
        .card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; border: none; cursor: pointer; }
        .btn-secondary { background: #6b7280; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, select { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; }
        .error { color: red; font-size: 13px; margin-top: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tambah Produk</h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}">
                    @error('sku') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}">
                    @error('price') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}">
                    @error('stock') <div class="error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>
