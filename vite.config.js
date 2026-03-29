import { defineConfig } from 'vite'

export default defineConfig({
  build: {
    outDir: 'js/dist',
    emptyOutDir: true,
    lib: {
      entry: 'js/src/main.js',
      name: 'fse',
      formats: ['iife'],
      fileName: () => 'bundle.js',
    },
    rollupOptions: {
      output: {
        inlineDynamicImports: true,
      },
    },
  },
})
