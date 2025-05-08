import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import "./FeaturedProducts.css";

const products = [
  {
    id: 1, //Nirvana
    name: "Nirvana - Come As You Are",
    image: "/imagestshirt/Nirvana-come-ass-you-are.jpg",
    price: "15,500 THB (USD 460)",
    category: "Nirvana",
  },

  {
    id: 1.1, 
    name: "Nirvana - Silver",
    image: "/imagestshirt/nirvanasilver.jpg",
    price: "55,000 THB (USD 460)",
    category: "Nirvana",
  },
  //...............Nirvana.................................... 
  {
    id: 2, //Queen
    name: "Queen - Classic Logo",
    image: "/imagestshirt/Queen.jpg",
    price: "8,000 THB (USD 237)",
    category: "Queen",
  },
  // ..............Queen......................................
  {
    id: 3, //Green day
    name: "Green Day - Dookie",
    image: "/imagestshirt/Green-Day.jpg",
    price: "18,500 THB (USD 549)",
    category: "Green Day",
  },

  {
    id: 3.1,
    name: "Green Day - kerplunk",
    image: "/imagestshirt/Green-Day-kerplunk-ID3.1.jpg",
    price: "12,000 THB (USD 347)",
    category: "Green Day",
  },

  // ..............Green Day..................................
  {
    id: 4, 
    name: "Silverchair",
    image: "/imagestshirt/silverchair.jpg",
    price: "5,000 THB (USD 147)",
    category: "Silverchair",
  },
  {
    id: 4.1,
    name: "Silverchairred",
    image: "/imagestshirt/silverchairred.jpg",
    price: "6,500 THB (USD 191)",
    category: "Silverchair",
  },
  // ..............Silverchair...............................

  {
    id: 5,
    name: "Alice in Chains",
    image: "/imagestshirt/AliceinChainsid1.jpg",
    price: "25,000 THB (USD 724)",
    category: "Alice in Chains"
  },
  //...........Alice in Chains................................
  {
    id: 6,
    name: "Eminem - Shady",
    image: "/imagestshirt/Eminemshadyid6.jpg",
    price: "18,000 THB (USD 521)",
    category: "Eminem"
  }
  //...........Eminem.....................................
];


const FeaturedProducts = ({ category }) => {
  const [filteredProducts, setFilteredProducts] = useState([]);

  // ใช้ useEffect เพื่อตรวจสอบการเปลี่ยนแปลงของ category
  useEffect(() => {
    if (category) {
      // กรองสินค้าเมื่อ category เปลี่ยน
      const newFilteredProducts = products.filter(
        (product) => product.category === category
      );
      setFilteredProducts(newFilteredProducts);
    } else {
      // หากไม่มี category, แสดงสินค้าทั้งหมด
      setFilteredProducts(products);
    }
  }, [category]);  // ทุกครั้งที่ category เปลี่ยน, จะรีเฟรชข้อมูลสินค้า

  return (
    <div className="featured-products">
      <h2 className="section-title">VinTage-TShirt</h2>
      <div className="product-list">
        {filteredProducts.length > 0 ? (
          filteredProducts.map((product) => (
            <div key={product.id} className="product-card">
              <Link to={`/ProductDetail/${product.id}`}>
                <img
                  src={product.image}
                  alt={product.name}
                  className="product-image"
                />
              </Link>
              <h3 className="product-name">{product.name}</h3>
              <p className="product-price">{product.price}</p>
            </div>
          ))
        ) : (
          <p>ไม่พบสินค้าสำหรับหมวดหมู่นี้</p>
        )}
      </div>
    </div>
  );
};

export default FeaturedProducts;
