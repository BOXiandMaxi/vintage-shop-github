import React, { useEffect } from "react";
import axios from "axios";
import { useUserContext } from "../Context/UserContext";

const SessionLoader = ({ children }) => {
  const { setUserName, setUserEmail } = useUserContext();

  useEffect(() => {
    const checkSession = async () => {
      try {
        const response = await axios.get("http://localhost:8000/check_login_v2.php", {
          withCredentials: true,
        });

        // console.log("🎯 response from check_login_v2.php:", response.data);

        if (response.data.status === "ok") {
          const { firstName, email } = response.data;

          // console.log("✅ SETTING CONTEXT:", { firstName, email });

          // ✅ เซ็ตค่าลง context
          setUserName(firstName);
          setUserEmail(email);
        } else {
          console.warn("⛔ ไม่มี session login");
        }
      } catch (error) {
        console.error("❌ Session check error:", error);
      }
    };

    checkSession();
  }, [setUserName, setUserEmail]);

  return <>{children}</>;
};

export default SessionLoader;
