// import React, { useState } from "react";
// import axios from "axios";
// import { useNavigate } from "react-router-dom";

// const Login = () => {
//   const [email, setEmail] = useState("");
//   const [password, setPassword] = useState("");
//   const navigate = useNavigate();

//   const handleSubmit = (e) => {
//     e.preventDefault();

//     axios.post("http://localhost/vintage-shop/backend/loginandregister/process_login.php", {
//       email,
//       password,
//     }, { withCredentials: true })
//       .then((response) => {
//         if (response.data.success) {
//           // ถ้าล็อกอินสำเร็จ ให้ไปหน้าแรก
//           navigate("/");
//         } else {
//           alert(response.data.message);
//         }
//       })
//       .catch((err) => {
//         console.error(err);
//         alert("เกิดข้อผิดพลาดในการเข้าสู่ระบบ");
//       });
//   };

//   return (
//     <div>
//       <h2>Login</h2>
//       <form onSubmit={handleSubmit}>
//         <input
//           type="email"
//           value={email}
//           onChange={(e) => setEmail(e.target.value)}
//           placeholder="Email"
//         />
//         <input
//           type="password"
//           value={password}
//           onChange={(e) => setPassword(e.target.value)}
//           placeholder="Password"
//         />
//         <button type="submit">Login</button>
//       </form>
//     </div>
//   );
// };

// export default Login;
