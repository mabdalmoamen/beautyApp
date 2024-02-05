class AppStorage {
    storeToken(token) {
        localStorage.setItem("token", token);
    }
    storeTtl(ttl) {
        localStorage.setItem("ttl", ttl);
    }
    storeUser(user) {
        localStorage.setItem("user", user);
    }
    storeId(id) {
        localStorage.setItem("user_id", id);
    }
    storeLang(lang) {
        localStorage.setItem("lang", lang);
    }
    store(token, user, id, ttl, lang) {
        this.storeToken(token);
        this.storeUser(user);
        this.storeId(id);
        this.storeTtl(ttl);
        this.storeLang(lang)
    }

    clear() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        localStorage.removeItem("user_id");
        // localStorage.removeItem("vat");
        localStorage.removeItem("ttl");
        // localStorage.clear();
    }

    getToken() {
        localStorage.getItem("token");
    }
    getTtl() {
        localStorage.getItem("ttl");
    }
    getUser() {
        localStorage.getItem("user");
    }
}

export default AppStorage = new AppStorage();