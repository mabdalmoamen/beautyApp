import AppStorage from "./AppStorage";

class Auth {
    async getAuth() {
        Auth = null;
        await axios.post("/api/auth/me").then((data) => {
            if (!data.data.id) {
                AppStorage.clear();
                window.location("/");
            }
            Auth = data.data;
        });
        return Auth;
    }
}

export default Auth = new Auth();
