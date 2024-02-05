import Token from "./Token";
import AppStorage from "./AppStorage";

class User {
    responseAfterLogin(res) {
        var today = new Date();

        const access_token = res.data.access_token;
        const username = res.data.username;
        const userId = res.data.user_id;

        const ttl = today.setHours(today.getHours() + 8);
        // console.log(res);
        if (Token.isValid(access_token)) {
            AppStorage.store(
                access_token,
                username,
                userId,
                ttl,
                res.data.lang
            );
        }
    }

    hasToken() {
        let storeToken = localStorage.getItem("token");
        let ttl = localStorage.getItem("ttl");

        if (!storeToken && !ttl) {
            return false;
        }

        const now = new Date();

        // compare the expiry time of the item with the current time
        if (now.getTime() > ttl) {
            localStorage.removeItem("token");
            localStorage.removeItem("ttl");
            return false;
        }

        storeToken = localStorage.getItem("token");
        if (storeToken) {
            return Token.isValid(storeToken) ? true : false;
        }
        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    name() {
        if (this.loggedIn()) {
            return localStorage.getItem("user");
        }
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(localStorage.getItem("token"));
            return payload.sub;
        }
        return false;
    }
}

export default User = new User();