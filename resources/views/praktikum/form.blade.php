<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Praktikum BKPM - Form Validasi</title>
</head>
<body>
    <main>
        <h1>Form Praktikum BKPM</h1>

        @if ($errors->any())
            <div role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <p role="status">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('praktikum.form.submit') }}">
            @csrf
            <h2>Validasi dasar</h2>
            <label for="basic-name">Nama</label>
            <input id="basic-name" name="name" value="{{ old('name') }}" required>
            <label for="basic-email">Email</label>
            <input id="basic-email" name="email" type="email" value="{{ old('email') }}" required>
            <button type="submit">Kirim</button>
        </form>

        <form method="POST" action="{{ route('praktikum.form.request') }}">
            @csrf
            <h2>UserRequest</h2>
            <label for="request-name">Nama</label>
            <input id="request-name" name="name" value="{{ old('name') }}" required>
            <label for="request-email">Email</label>
            <input id="request-email" name="email" type="email" value="{{ old('email') }}" required>
            <button type="submit">Kirim</button>
        </form>

        <form method="POST" action="{{ route('praktikum.form.uppercase') }}">
            @csrf
            <h2>Rule Uppercase</h2>
            <label for="first-name">Nama depan (huruf kapital)</label>
            <input id="first-name" name="first_name" value="{{ old('first_name') }}" required>
            <button type="submit">Kirim</button>
        </form>
    </main>
</body>
</html>