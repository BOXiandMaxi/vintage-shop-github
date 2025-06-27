import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import "./FeaturedProducts.css";

const FeaturedProducts = ({ category, isInShopPage }) => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const load = async () => {
      setLoading(true);
      try {
        const url = category
          ? `http://localhost:8001/get_products.php?category=${encodeURIComponent(category)}`
          : `http://localhost:8001/get_products.php`;

        const res  = await fetch(url);
        const data = await res.json();
        setProducts(data);
      } catch (err) {
        console.error("Fetch products error:", err);
        setProducts([]);
      } finally {
        setLoading(false);
      }
    };
    load();
  }, [category]);

  if (loading) return <p>กำลังโหลด…</p>;
  if (!products.length) return <p>ไม่พบสินค้า</p>;

  return (
    <div className={`featured-products ${isInShopPage ? "in-shop" : "in-home"}`}>
      <h2 className="section-title">VinTage-TShirt</h2>
      <div className="product-list">
        {products.map(p => (
          <div key={p.id} className="product-card">
            <Link to={`/ProductDetail/${p.id}`}>
              {/* ❌ ไม่เติม http://localhost:8001 ❌ */}
              <img src={p.image_url} alt={p.name} className="product-image" />
            </Link>
            <h3 className="product-name">{p.name}</h3>
            <p className="product-price">{p.price_text}</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default FeaturedProducts;
