const {defineConfig} = require("@vue/cli-service");
module.exports = defineConfig({
    transpileDependencies: true,
    devServer: {
        allowedHosts: [
            "localhost",
            "localhost:8080",
            "127.0.0.1.nip.io",
            "127.0.0.1.nip.io:8080",
        ],
    }
});
