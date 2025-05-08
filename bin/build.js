import * as esbuild from 'esbuild'

esbuild.build({
    entryPoints: ['./resources/js/advance-file-upload.js'],
    outfile: './resources/dist/js/advance-file-upload.js',
    bundle: true,
    mainFields: ['module', 'main'],
    platform: 'neutral',
    treeShaking: true,
    target: ['es2020'],
    allowOverwrite: true,
    minify: true,
})
