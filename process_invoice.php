<?php
// Get form data
$clientName = $_POST['client_name'];
$clientEmail = $_POST['client_email'];
$itemNames = $_POST['item_name'];
$quantities = $_POST['quantity'];
$unitPrices = $_POST['unit_price'];

// Initialize totals
$items = [];
$subtotal = 0;

for ($i = 0; $i < count($quantities); $i++) {
    $name = $itemNames[$i];
    $qty = (int)$quantities[$i];
    $price = (float)$unitPrices[$i];

    if ($name && $qty > 0 && $price > 0) {
        $total = $qty * $price;
        $items[] = [
            'name' => $name,
            'quantity' => $qty,
            'unit_price' => $price,
            'total' => $total
        ];
        $subtotal += $total;
    }
}

$taxRate = 0.05; // 5% VAT
$tax = $subtotal * $taxRate;
$grandTotal = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        h2 { margin-bottom: 0; }
    </style>
</head>
<body>

    <h2>Invoice for <?= htmlspecialchars($clientName) ?></h2>
    <p>Email: <?= htmlspecialchars($clientEmail) ?></p>

    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['unit_price'], 2) ?></td>
                <td><?= number_format($item['total'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="3">Subtotal</td><td><?= number_format($subtotal, 2) ?></td></tr>
            <tr><td colspan="3">Tax (5%)</td><td><?= number_format($tax, 2) ?></td></tr>
            <tr><td colspan="3"><strong>Grand Total</strong></td><td><strong><?= number_format($grandTotal, 2) ?></strong></td></tr>
        </tfoot>
    </table>

</body>
</html>
