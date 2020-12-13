const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyPlugin = require("copy-webpack-plugin");

module.exports = {
  entry: './src/index.js',
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'styles/style.[contenthash].css',
    }),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: 'http://josephshabason.localhost'
    }),
    new CopyPlugin({
      patterns: [
        { from: "src/styles/icofont.min.css", to: "styles/icofont.min.css" },
        { from: "src/styles/fonts", to: "styles/fonts" },
      ],
      options: {
        concurrency: 100,
      },
    }),
  ],
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist'),
  },
  module:{
    rules:[
      {
        test:/\.(s*)css$/,
        use:[MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
      }
    ]
  },
  watch: true,
};