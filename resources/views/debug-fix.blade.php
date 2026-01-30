<!DOCTYPE html>
<html>
<head>
    <title>Debug Products</title>
    <style>
        body { padding: 20px; font-family: Arial; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>🛠️ Debug Products Fix</h1>

    <h3>📊 All Products in Database:</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Test Link</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->slug ?? '<span class="error">NULL</span>' }}</td>
            <td>{{ $product->status }}</td>
            <td>
                @if($product->slug)
                    <a href="/products/{{ $product->slug }}" target="_blank" class="success">
                        Test: /products/{{ $product->slug }}
                    </a>
                @else
                    <span class="error">No slug!</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    <h3>🔗 Test These URLs:</h3>
    <ul>
        @foreach($products->take(5) as $product)
            @if($product->slug)
            <li><a href="/products/{{ $product->slug }}" target="_blank">/products/{{ $product->slug }}</a></li>
            @endif
        @endforeach
    </ul>

    <h3>⚙️ Route Check:</h3>
    <p>Current route defined: <code>/products/{slug}</code></p>

    <h3>🔄 Quick Fixes:</h3>
    <ol>
        <li>If slugs are NULL, run: <code>php artisan tinker</code> then: <code>\App\Models\Product::all()->each(function($p) { $p->slug = \Illuminate\Support\Str::slug($p->name); $p->save(); });</code></li>
        <li>Clear cache: <code>php artisan optimize:clear</code></li>
        <li>Check ProductController has show() method</li>
    </ol>
</body>
</html>
