<!DOCTYPE html>
<html>
<head>
    <title>Product Barcode</title>
</head>
<body>
    <div class="barcode-container">
        {{-- Output barcode HTML --}}
        {!! $barcodeHTML !!}
        <p> {{ $product->barcode }}</p>
    </div>
</body>
</html>
