<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'itemconnect.php';

$products = [
  ['Nirvana - Come As You Are', '/imagestshirt/Nirvana-come-ass-you-are.jpg', 15500.00, '15,500 THB (USD 460)', 'Nirvana'],
  ['Nirvana - Silver', '/imagestshirt/nirvanasilver.jpg', 55000.00, '55,000 THB (USD 460)', 'Nirvana'],
  ['Queen - Classic Logo', '/imagestshirt/Queen.jpg', 8000.00, '8,000 THB (USD 237)', 'Queen'],
  ['Green Day - Dookie', '/imagestshirt/Green-Day.jpg', 18500.00, '18,500 THB (USD 549)', 'Green Day'],
  ['Green Day - kerplunk', '/imagestshirt/Green-Day-kerplunk-ID3.1.jpg', 12000.00, '12,000 THB (USD 347)', 'Green Day'],
  ['Silverchair', '/imagestshirt/silverchair.jpg', 5000.00, '5,000 THB (USD 147)', 'Silverchair'],
  ['Silverchairred', '/imagestshirt/silverchairred.jpg', 6500.00, '6,500 THB (USD 191)', 'Silverchair'],
  ['Alice in Chains', '/imagestshirt/AliceinChainsid1.jpg', 25000.00, '25,000 THB (USD 724)', 'Alice in Chains'],
  ['Eminem - Shady', '/imagestshirt/Eminemshadyid6.jpg', 18000.00, '18,000 THB (USD 521)', 'Eminem']
];

$stmt = $conn->prepare("INSERT INTO itemshop (name, image_url, price, price_text, category) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

foreach ($products as $p) {
  $stmt->bind_param("ssdss", $p[0], $p[1], $p[2], $p[3], $p[4]);
  $stmt->execute();
}

echo "เพิ่มข้อมูลสินค้าสำเร็จ!";
?>
