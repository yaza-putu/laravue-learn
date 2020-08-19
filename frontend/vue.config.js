module.exports = {
    devServer: {
        proxy: "http://localhost:8082"
    },
    outputDir: "../public",
    transpileDependencies: ["vuetify"],
    indexPath:
        process.env.NODE_ENV === "production"
            ? "../resources/views/index.blade.php"
            : "index.html"
};
