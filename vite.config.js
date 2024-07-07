import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vitest/config";
import copy from "rollup-plugin-copy";
import path from "path";

const env = process.env.NODE_ENV || "production";

export default defineConfig({
    esbuild: {
        // Keep names on classes during minification to preserve error names for type guards
        keepNames: true,
    },
    plugins: [
        laravel({
            input: ["resources/front/main.ts", "resources/sass/app.scss"],
            refresh: true,
        }),
        vue({
            base: null,
            includeAbsolute: false,
            template: {
                compilerOptions: {
                  isCustomElement: (tag) => tag.includes('i-')
                }
              },
        }),
        copy({
            targets: [
                {
                    src: "node_modules/pspdfkit/dist/pspdfkit-lib/*",
                    dest: "public/js/pspdfkit-lib",
                },
            ],
            hook: "buildStart",
        }),
    ],
    resolve: {
        alias: {
            "@@": "/node_modules",
            "@": "/resources/front",
            "@styles": "/resources/styles",
            "@assets": "/resources/assets",
            "@assetsroot": "/",
            "@images": path.resolve(__dirname, "public/images"),
            "@imgs": "/public/img",
        },
    },
    server: {
        http: env === "production",
        // hmr: {
        //     host: "revboard.test",
        // },
        host: "0.0.0.0",
        port: 5178,
    },
    test: {
        environment: "jsdom",
        include: ["resources/front/**/*.test.ts"],
        setupFiles: ["./vitest.setup.ts"],
    },
    build: {
        outDir: "public/build",
        base: "/build/",
    },
});
